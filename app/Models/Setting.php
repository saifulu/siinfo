<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'setting';
    protected $primaryKey = 'nama_instansi';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'nama_instansi',
        'alamat_instansi',
        'kabupaten',
        'propinsi',
        'kontak',
        'email',
        'aktifkan',
        'kode_ppk',
        'kode_ppkinhealth',
        'kode_ppkkemenkes',
        'wallpaper',
        'logo'
    ];
} 