<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_aspirasi';
    protected $table = 'aspirasi';
    protected $fillable = [
        'keterangan',
        'lokasi',
        'id_kategori',
        'feedback',
        'rating',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }
     public function inputaspirasi()
    {
        return $this->hasOne(InputAspirasi::class, 'id_pelaporan', 'id_pelaporan');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis', 'nis');
    }
}