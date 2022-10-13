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
class Kota extends Model
{
    use SoftDeletes;
    public $table = 'kota';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    public $fillable = [ 
        'id',
        'name',
        'provinsi_id',
        'input_by',
        'last_edited_by'
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

    public function provinsi()
    {
        return $this->hasOne(Provinsi::class, 'provinsi_id');
    }
}
