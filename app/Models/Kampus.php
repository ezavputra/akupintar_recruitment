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
class Kampus extends Model
{
    use SoftDeletes;
    public $table = 'kampus';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    public $fillable = [
        'id',
        'name',
        'jeniskampus_id',
        'statuskampus_id',
        'akreditasi',
        'kota_id',
        'is_featured',
        'is_politeknik',
        'is_active',
        'input_by',
        'last_edited_by',
        'created_at',
        'updated_at'
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

    public function jenis_kampus()
    {
        return $this->belongsTo(TipeJenisKampus::class, 'jeniskampus_id');
    }
    public function status_kampus()
    {
        return $this->belongsTo(StatusKampus::class, 'statuskampus_id');
    }
    public function kota()
    {
        return $this->hasOne(Kota::class, 'id');
    }
}
