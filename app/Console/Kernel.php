<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Order;
use App\Models\OrderLogsModel;
use App\Models\OrderTeraphisModel;
use App\Http\Controllers\API\OrderMassageController;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $fcmtoken = array();
            $data = Order::whereIn('status_id',[0,7,31])
                ->with('category')
                ->with('customers')
                ->get();
            $data_massage = Order::whereIn('status_id',[37])
                ->with('category')
                ->with('customers')
                ->with('order_teraphis')
                ->get();
            foreach($data as $row){   
                $datenow=date("Y-m-d H:i");
                $datexp=date("Y-m-d H:i",strtotime($row->expiry_date));
                if ($row->category_id !='008'){
                    $status =24;
                    $body ='Order No. ' . $row->order_no . ' telah kadaluarsa karena melebihi batas pembayaran.';
                    $note= 'Order  telah kadaluarsa karena melebihi batas pembayaran.';
                }else{
                    $status =32;
                    $body ='Order No. ' . $row->order_no . ' Dibatalkan : Terapis tidak ditemukan';
                    $note ='Order  Dibatalkan : Terapis tidak ditemukan';
                }
                         
                if ($datenow >= $datexp) {
                    Order::where('id',$row->id)
                    ->update([
                        'status_id' => $status //cancel order customner status
                    ]);
                    OrderLogsModel::create([
                        'order_id'=>$row->id,
                        'order_status_id'=>$status,
                        'note'=>$note
                    ]);
                    // array_push($fcmtoken, $row->customers->users->fcm_token); 
                    fcm()
                        ->to($row->customers->users->fcm_token)
                        ->notification([
                            'title' => 'Order Kadaluarsa',
                            'subtitle' => 'Order Kadaluarsa Sub',
                            'body' => $body,
                            'priority' => 'high',
                            'sound' => 'default',
                            'auto_cancel' => true,
                            'lights' => true,
                            'channel' => 'my_default_channel',
                            'vibrate' => 300,
                            'status' => '400',
                            'click_action' => 'com.panggiltukangcustomer'
                        ])
                        ->data([
                            'screen' => $row->category->route_detail,
                            'order_id' => $row->id,
                            'status_id' => $row->status_id,
                        ])
                        ->send();   
                } 
            }
            foreach($data_massage as $row){   
                $datenow = date("Y-m-d H:i");
                if ($row->order_teraphis->finish_date != null) {
                    $finish_time_format = strtotime($row->order_teraphis->finish_date);
                    $datexp = date('Y-m-d H:i:s', strtotime('+30 seconds', $finish_time_format));
                    // $datexp = date("Y-m-d H:i", strtotime($row->order_teraphis->finish_date));
                }
                $status = 39;
                $body = 'Order No. ' . $row->order_no . ' telah selesai pengerjaan.';
                $note = 'Order telah selesai dilakukan pengerjaan.';
                
                if ($row->order_teraphis->finish_date != null) {
                    if ($datenow >= $datexp) {
                        $order_massage = new OrderMassageController();
                        $order_massage->teraphisSelesaiMassage($row->id, 'kernel');

                        $status = 39;

                        OrderTeraphisModel::where('order_id', $row->id)
                            ->where('teraphis_id', $row->order_teraphis->teraphis->id)
                            ->update([
                                'status' => $status
                            ]);

                        Order::where('id', $row->id)
                            ->update([
                                'status_id' => $status //cancel order customner status
                            ]);

                        OrderLogsModel::create([
                            'order_id'=>$row->id,
                            'order_status_id'=>$status,
                            'note'=>$note
                        ]);

                        fcm()
                            ->to($row->customers->users->fcm_token)
                            ->notification([
                                'title' => 'Pengerjaan Sudah Selesai',
                                'subtitle' => 'Pengerjaan terapis anda telah selesai',
                                'body' => $body,
                                'priority' => 'high',
                                'sound' => 'default',
                                'auto_cancel' => true,
                                'lights' => true,
                                'channel' => 'my_default_channel',
                                'vibrate' => 300,
                                'status' => '400',
                                'click_action' => 'com.panggiltukangcustomer'
                            ])
                            ->data([
                                'screen' => $row->category->route_detail,
                                'order_id' => $row->id,
                                'status_id' => $row->status_id,
                            ])
                            ->send();   

                        fcm()
                            ->to($row->order_teraphis->teraphis->user->fcm_token)
                            ->notification([
                                'title' => 'Durasi Pengerjaan Sudah Habis',
                                'subtitle' => 'Jangan lupa untuk meminta rating & review dari customer',
                                'body' => $body,
                                'priority' => 'high',
                                'sound' => 'long_mitra.wav',
                                'auto_cancel' => true,
                                'lights' => true,
                                'channel' => 'tukang_long',
                                'android_channel_id' => 'tukang_long',
                                'vibrate' => 300,
                                'status' => '400',
                                'click_action' => 'com.panggiltukang.mitrateraphis'
                            ])
                            ->data([
                                'screen' => $row->category->route_detail,
                                'order_id' => $row->id,
                                'status_id' => $row->status_id,
                            ])
                            ->send(); 
                    } 
                }
            }
         })->everyMinute();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
