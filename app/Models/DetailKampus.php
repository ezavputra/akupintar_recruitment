<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
/**
 * Class Tukang
 * @package App\Models
 * @version April 9, 2017, 1:11 pm UTC
 */
class DetailKampus extends Model
{
    use SoftDeletes;
    public $table = 'detail_kampus';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    public $fillable = [
        'id',
        'id_kampus',
        'notelp',
        'fax',
        'alamat',
        'website',
        'longitude',
        'latitude',
        'zip',
        'profil',
        'input_by',
        'last_edited_by',
    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id' => 'required'
    ];

    protected $appends = [];

    // public function getPaymentMethodCodeAttribute($value)
    // {
    //     $attributes = $this->getAttributes();

    //     if (isset($attributes['payment_method_id'])) {
    //         //  $order = Order::where('id', $attributes['id'])->with('payment_survey')->first();         
    //         $paymentmethod = PaymentMethods::find($attributes['payment_method_id']);
    //         if ($paymentmethod) {
    //             return $paymentmethod->code;
    //         }
    //     }

    //     return null;
    // }

    public function kampus()
    {
        return $this->hasOne(Kampus::class, 'id_kampus', 'id');
    }
}
