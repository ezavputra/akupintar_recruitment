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
class JurusanKampus extends Model
{
    use SoftDeletes;
    public $table = 'jurusan_kampus';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    public $fillable = [
        'id',
        'kampus_id',
        'jurusan_id',
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

    public function kampus()
    {
        return $this->belongsTo(Kampus::class, 'kampus_id')->with('kota');
    }
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }
}
