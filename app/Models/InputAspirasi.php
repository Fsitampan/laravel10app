<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InputAspirasi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_pelaporan';
    protected $table = 'input_aspirasi';
    protected $fillable = [
        'nis',
        'keterangan',
        'lokasi',
        'id_kategori'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }
     public function aspirasi()
    {
        return $this->hasOne(aspirasi::class, 'id_pelaporan', 'id_pelaporan');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis', 'nis');
    }
}