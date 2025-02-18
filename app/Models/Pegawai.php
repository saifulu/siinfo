<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'pegawai';
    
    public $timestamps = false;

    protected $fillable = [
        'nik',
        'nama',
        'jk',
        'jbtn'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'nik', 'id_user');
    }
} 