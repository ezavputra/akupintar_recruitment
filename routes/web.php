<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

use App\Mail\PaymentMail;
use Yajra\Datatables\Facades\Datatables;


Auth::routes();

Route::post('/winpay/callback', 'WinpayController@callback');
Route::post('/winpay/listener', 'WinpayController@listener');
Route::post('/midtrans/listener', 'MidtransResponse@listener');
Route::get('/midtrans/finishredirect', 'MidtransFinish@listener');

Route::get('/winpay/inquiry', 'WinpayResponse@inquiry');
Route::get('/winpay/payment', 'WinpayResponse@payment');

Route::get('/mcpay/callback', 'MCPayResponse@callback');
Route::get('/mcpay/return', 'MCPayResponse@return');
Route::get('/notification/sendchat', 'NotificationController@sendchat')->name('notification.sendchat');
Route::get('/notification/kirim', 'NotificationController@kirim')->name('notification.kirim');

Route::group(['middleware' => ['auth', 'role', 'log']], function () {
    Route::get('/', function () {
        return redirect('home');
    });
    
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/home/payment_surveys', 'HomeController@payment_surveys');
    Route::get('/home/payment_orders', 'HomeController@payment_orders');
    Route::get('/home/order_not_yet_taken', 'HomeController@order_not_yet_taken');
    Route::resource('categories', 'CategoryController');
    Route::post('/payment_methods/sync_winpay', 'PaymentMethodsController@sync_winpay')->name('payment_methods.sync_winpay');
    Route::resource('payment_methods', 'PaymentMethodsController');
    Route::resource('paymentmethodinfo', 'PaymentMethodInfoController');
    Route::resource('district', 'DistrictController');
    Route::resource('tukang', 'TukangController');
    Route::resource('mitra_tukang', 'MitraTukangController');
    Route::resource('status_order', 'StatusOrderController');
    Route::resource('histori_order', 'HistoriOrderController');
    Route::resource('histori_massage_order', 'HistoriMassageOrderController');
    Route::resource('customer', 'CustomerController');
    Route::resource('main_categories', 'MainCategoriesController');
    Route::resource('slide', 'SlideController');
    Route::resource('services', 'ServicesController');
    Route::resource('fcm', 'NotificationController');
    Route::resource('merchant', 'MerchantController');
    Route::resource('employee_merchant', 'MerchantEmployeeController');
    Route::resource('menu_merchant', 'MerchantMenuController');
    Route::resource('jenis_merchant', 'MerchantJenisController');
    Route::resource('kategori_merchant', 'MerchantKategoriController');
    Route::resource('notification_sms', 'NotificationSmsController');
    Route::resource('inbox', 'NotificationInboxController');
    Route::resource('paymentsurvey', 'PaymentSurveyController');
    Route::resource('paymentorder', 'PaymentOrderController');
    Route::resource('users', 'UserController');
    Route::resource('settings', 'SettingController');
    Route::resource('wallet_tukang', 'WalletTukangController');
    Route::resource('wallet_massage', 'WalletMassageController');
    Route::resource('bankaccount', 'BankAccountController');
    Route::resource('coupons', 'CouponController');
    Route::resource('role', 'RoleController');
    Route::resource('accesslog', 'AccessLogController');
    Route::resource('withdraw', 'WithdrawController');
    Route::resource('page_main', 'PageMainController');
    Route::resource('page_sub', 'PageSubController');
    Route::resource('page_header', 'PageHeaderController');
    Route::resource('massage', 'MassageController');
    Route::resource('service_massage', 'ServicesMassageController');
    Route::resource('journal_account', 'JournalAccountController');
    Route::resource('journal_detail', 'JournalController');
    Route::resource('news_categories', 'NewsCategoryController');
    Route::resource('news', 'NewsController');
    Route::resource('news_detail', 'NewsDetailController');
    Route::resource('article_wp', 'ArticleWPController');
    Route::resource('article_wp_cat', 'ArticleWPCatController');
    Route::resource('article_wp_tag', 'ArticleWPTagController');

    Route::get('/bonus', 'BonusController@test');

    // Route ArticleWP
    Route::get('/article_wp/1/sync_article', 'ArticleWPController@sync_article')->name('article_wp.sync');
    Route::get('article_wp/{mode}/{id}', 'ArticleWPController@active_article')->name('article_wp.active_article');

    // Route Access Log
    Route::post('/accesslog/post/exportlogexcel', 'AccessLogController@export_log_excel')->name('accesslog.exportlogexcel');

    //Route Bank Account
    Route::patch('/bankupdate/{id}', 'BankAccountController@bankupdate')->name('bankaccount.bankupdate');

    //Route Customer
    Route::post('/customer/post/exportcustomerexcel', 'CustomerController@export_customer_excel')->name('customer.exportcustomerexcel');
    Route::post('/customer/post/exportcustomercsv', 'CustomerController@export_customer_csv')->name('customer.exportcustomercsv');
    Route::get('/getgraph/{mode}/{date}', 'CustomerController@getGraph')->name('customer.getgraph');

    //Route History Order
    Route::post('/histori_order/post/exporthistorderexcel', 'HistoriOrderController@export_historder_excel')->name('histori_order.exporthistorderexcel');
    Route::patch('/histori_order/{id}/ganti_tukang', 'HistoriOrderController@ganti_tukang')->name('histori_order.ganti_tukang');
    Route::patch('/histori_order/{id}/open_bid', 'HistoriOrderController@open_bid')->name('histori_order.open_bid');
    Route::patch('/histori_order/{id}/batal_order', 'HistoriOrderController@batal_order')->name('histori_order.batal_order');
    Route::patch('/histori_order/{id}/update_survey/{row}', 'HistoriOrderController@update_survey')->name('histori_order.update_survey');
    Route::post('/histori_order/{id}/update_survey2/{row}', 'HistoriOrderController@update_survey')->name('histori_order.update_survey2');

    //Route Jurnal
    Route::get('/journal_detail/getByDate/{date}', 'JournalController@getByDate')->name('journal.getByDate');

    //Route Kategori
    Route::get('/categories/aktifasi/{id}', 'CategoryController@aktifasi')->name('categories.aktifasi');

    //Route Massage
    Route::get('/massage/aktifasi/{id}', 'MassageController@aktifasi')->name('massage.aktifasi');
    Route::post('/massage/topupsaldo', 'MassageController@topupsaldo')->name('massage.topupsaldo');

    Route::get('/mitra_tukang/{id}/getwallet/{user_id}', 'MitraTukangController@getWalletDataTables');
    Route::get('/mitra_tukang/aktifasi/{id}', 'MitraTukangController@aktifasi')->name('mitra_tukang.aktifasi');
    Route::post('/mitra_tukang/insertbankacc', 'MitraTukangController@insertbankacc')->name('mitra_tukang.insertbankacc');
    Route::post('/mitra_tukang/updatebankacc/{id}', 'MitraTukangController@updatebankacc')->name('mitra_tukang.updatebankacc');
    Route::get('/mitra_tukang/workprogress', 'MitraTukangController@getWorkProgress');
    Route::get('/mitra_tukang/workhistory', 'MitraTukangController@getWorkHistory')->name('mitra_tukang.work_history');
    Route::get('/mitra_tukang/gantipassword/{id}/userid/{user_id}', 'MitraTukangController@gantipassword')->name('mitra_tukang.gantipassword');

    //Route Merchant
    Route::get('/merchant/aktifasi/{id}', 'MerchantController@aktifasi')->name('merchant.aktifasi');
    Route::get('/merchant_employee/aktifasi/{id}', 'MerchantEmployeeController@aktifasi')->name('employee_merchant.aktifasi');
    Route::get('/jasa_merchant/{id}', 'MerchantMenuController@list_menu')->name('menu_merchant.list_menu');
    // Route::get('/menu_merchant/{id}/create', 'MerchantMenuController@create')->name('menu_merchant.create');
    // Route::get('/menu_merchant/{id}/show', 'MerchantMenuController@show')->name('menu_merchant.show');
    // Route::get('/menu_merchant/{id}/edit', 'MerchantMenuController@edit')->name('menu_merchant.edit');
    // Route::get('/menu_merchant/{id}/destroy', 'MerchantMenuController@destroy')->name('menu_merchant.destroy');

    //Route News Category & News
    Route::get('/news_categories/aktifasi_news/{id}', 'NewsCategoryController@aktifasi_news')->name('news_categories.aktifasi_news');
    Route::get('/news/add/{id}', 'NewsController@create_news')->name('news.create_news');
    Route::get('/news_detail/add/{id}', 'NewsDetailController@create_news_detail')->name('news_detail.create_news_detail');

    //Route Notifikasi SMS & FCM
    Route::post('/notification_sms/storeSettingSMS', 'SettingController@storeSettingSMS')->name('settings.storeSettingSMS');
    Route::get('/notification_sms/{type}', 'SettingController@notification_sms')->name('settings.notification_sms');
    Route::post('/notification_sms/2/send_sms', 'NotificationSmsController@send_sms')->name('notification_sms.send');
    Route::get('/notification_sms/5/download_excel', 'NotificationSmsController@download_excel')->name('notification_sms.downloadexcel');
    Route::get('/notification_sms/3/sync_report', 'NotificationSmsController@sync_report')->name('notification_sms.sync');
    Route::get('/fcmtoken/{fcmtoken}/{userid}', 'HomeController@fcmtoken')->name('home.fcmtoken');

    //Route Page Main
    Route::get('/page_main_list/{page_header_id}', 'PageMainController@page_main')->name('page_main.page_main');
    Route::get('/page_main_list/{page_header_id}/page_main_create', 'PageMainController@page_main_create')->name('page_main.page_main_create');
    Route::get('/page_main_list/{page_header_id}/page_main_detail/{id}', 'PageMainController@page_main_detail')->name('page_main.page_main_detail');
    Route::get('/page_main_list/{page_header_id}/page_main_edit/{id}', 'PageMainController@page_main_edit')->name('page_main.page_main_edit');

    //Route Page Sub
    Route::get('/page_sub_list/{page_main_id}', 'PageSubController@page_sub')->name('page_sub.page_sub');
    Route::get('/page_sub_list/{page_main_id}/page_sub_create', 'PageSubController@page_sub_create')->name('page_sub.page_sub_create');
    Route::get('/page_sub_list/{page_main_id}/page_sub_detail/{id}', 'PageSubController@page_sub_detail')->name('page_sub.page_sub_detail');
    Route::get('/page_sub_list/{page_main_id}/page_sub_edit/{id}', 'PageSubController@page_sub_edit')->name('page_sub.page_sub_edit');

    //Route Payment
    Route::post('/paymentorder/post/exportpayorderexcel', 'PaymentOrderController@export_paymentorder_excel')->name('paymentorder.exportpayorderexcel');

    Route::get('/paymentsurvey/sudahbayar/{id}', 'PaymentSurveyController@sudahbayar')->name('paymentsurvey.sudahbayar');
    Route::get('/paymentorder/sudahbayar/{id}', 'PaymentOrderController@sudahbayar')->name('paymentorder.sudahbayar');
    Route::get('/payment/aktifasi/{id}', 'PaymentMethodsController@aktifasi')->name('payment.aktifasi');

    //Route Report
    Route::get('/reports/orders_tukang', 'ReportController@orders_tukang')->name('reports.orders_tukang');
    Route::get('/reports/orders_massage', 'ReportController@orders_massage')->name('reports.orders_massage');
    Route::get('/reports/orders_tukang/{mode}/{year}/{month}', 'ReportController@download_order_tukang_report')->name('reports.downloadorderstukang');
    Route::get('/reports/orders_massage/{mode}/{year}/{month}', 'ReportController@download_order_massage_report')->name('reports.downloadordersmassage');

    //Route Slide
    Route::get('/slide/aktifasi/{id}', 'SlideController@aktifasi')->name('slide.aktifasi');

    //Route Sub Kategori
    Route::get('/subkategori/{id}', 'CategoryController@subkategori')->name('categories.subkategori');
    Route::get('/subkategori/{main_category_id}/create', 'CategoryController@create')->name('categories.create');
    Route::get('/subkategori/{main_category_id}/detail/{id}', 'CategoryController@detail')->name('categories.detail');
    Route::get('/subkategori/{main_category_id}/edit/{id}', 'CategoryController@edit')->name('categories.edit');

    //Route Tukang
    Route::get('/tukang/{id}/getwallet/{user_id}', 'TukangController@getWalletDataTables');
    Route::get('/tukang/aktifasi/{id}', 'TukangController@aktifasi')->name('tukang.aktifasi');
    Route::post('/tukang/insertbankacc', 'TukangController@insertbankacc')->name('tukang.insertbankacc');
    Route::post('/tukang/updatebankacc/{id}', 'TukangController@updatebankacc')->name('tukang.updatebankacc');
    Route::get('/tukang/gantipassword/{id}/userid/{user_id}', 'TukangController@gantipassword')->name('tukang.gantipassword');
    Route::get('/tukang/workprogress', 'TukangController@getWorkProgress');
    Route::get('/tukang/workhistory', 'TukangController@getWorkHistory')->name('tukang.work_history');

    Route::get('/getreview', 'TukangController@getReviewDataTable');

    //Route User
    Route::post('/users/add_role', 'UserController@add_role')->name('users.add_role');

    //Route Wallet
    Route::get('/wallet_tukang/{id}/exportexcelhistory', 'WalletTukangController@export_history_excel')->name('wallet.exporthistoryexcel');
    Route::get('/wallet_tukang/get/exportexcelwallet', 'WalletTukangController@export_wallet_excel')->name('wallet.exportwalletexcel');
    Route::get('/wallet_tukang/{id}/exportpdfhistory', 'WalletTukangController@export_history_pdf')->name('wallet.exporthistorypdf');
    Route::post('/wallet_tukang/topupsaldo', 'WalletTukangController@topupsaldo')->name('wallet.topupsaldo');

    //Route Wallet
    Route::get('/wallet_massage/{id}/exportexcelhistory', 'WalletMassageController@export_history_excel')->name('wallet_massage.exporthistoryexcel');
    Route::get('/wallet_massage/get/exportexcelwallet', 'WalletMassageController@export_wallet_excel')->name('wallet_massage.exportwalletexcel');
    Route::get('/wallet_massage/{id}/exportpdfhistory', 'WalletMassageController@export_history_pdf')->name('wallet_massage.exporthistorypdf');
    Route::post('/wallet_massage/topupsaldo', 'WalletMassageController@topupsaldo')->name('wallet_massage.topupsaldo');

    //Route Withdraw
    Route::get('/withdraw/verifikasi/{id}', 'WithdrawController@verifikasi')->name('withdraw.verifikasi');

    //Route::get('/tukang/actgantipass/{id}', 'TukangController@actgantipass')->name('slide.actgantipass');
    //Route::get('/tukang/actgantipass/{id}',[
    //     'as' => 'tukang.actgantipass',
    //     'uses' => 'TukangController@actgantipass'
    // ]);

    // Old
    Route::resource('order_sparepart', 'OrderSparepartController');
    Route::resource('order_job', 'OrderJobController');
    Route::resource('commission_sales', 'CommissionSalesController');
    Route::resource('commission_mechanic', 'CommissionMechanicController');
    Route::resource('productBrands', 'ProductBrandController');
    Route::resource('productUnitModels', 'ProductUnitModelController');
    Route::resource('products', 'ProductController');
    Route::resource('job_categories', 'JobCategoryController');

    Route::get('/sendmail/invoice/{id_order}', 'PaymentOrderController@sendemail')->name('paymentorder.sendemail');
    Route::get('/sendmail/test', 'MailController@tesEmail')->name('mail.sendemail');
    Route::get('/sendnotif', 'NotificationController@sendnotif')->name('notification.sendnotif');
    Route::get('/emailmarketing', function () {
        return redirect()->away("https://app.sendgrid.com/login/");
    })->name('emailmarketing');
    Route::get('/testing', function () {
        $stop_date = '2020-00-02';
        return date('Y-m-d', strtotime($stop_date . '+1 month +1 day'));
    })->name('emailmarketing');
});
