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
class UserFollowKampus extends Model
{
    use SoftDeletes;
    public $table = 'user_follow_kampus';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    public $fillable = [
        'id',
        'kampus_id',
        'user_id',
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

    // public function getPaymentMethodIconAttribute($value)
    // {
    //     $attributes = $this->getAttributes();

    //     if (isset($attributes['payment_method_id'])) {
    //         //  $order = Order::where('id', $attributes['id'])->with('payment_survey')->first();         
    //         $paymentmethod = PaymentMethods::find($attributes['payment_method_id']);
    //         if ($paymentmethod) {
    //             return $paymentmethod->icon;
    //         }
    //     }

    //     return null;
    // }

    public function kampus()
    {
        return $this->belongsTo(Kampus::class, 'kampus_id')->with('kota');
    }

    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }
}
