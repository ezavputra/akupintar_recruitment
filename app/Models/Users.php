<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Tukang
 * @package App\Models
 * @version April 9, 2017, 1:11 pm UTC
 */
class Users extends Authenticatable
{
    use SoftDeletes;
    public $table = 'users';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    public $fillable = [
        'id',
        'password',
        'email',
        'role',
        'api_token',
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

    public function user_detail()
    {
        return $this->belongsTo(UsersDetail::class, 'id');
    }
}
