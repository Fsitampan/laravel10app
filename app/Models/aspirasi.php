<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_aspirasi';
    protected $table = 'aspirasi';
    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

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
    return $this->belongsTo(InputAspirasi::class, 'id_aspirasi', 'id_pelaporan');
    }
}