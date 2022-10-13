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
class UsersDetail extends Model
{
    use SoftDeletes;
    public $table = 'users_detail';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    public $fillable = [
        'id',
        'user_id',
        'notelp',
        'full_name',
        'alamat',
        'kota_id',
        'umur'
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
}
