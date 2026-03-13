<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Siswa extends Authenticatable
{
    use HasFactory;
    protected $table = 'siswa';
    protected $primaryKey = 'nis';
    protected $keyType = 'int';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'nis',
        'password',
        'username',
        'kelas'
    ];

    public function getAuthPassword(){
        return $this->password;
    }

     public function inputaspirasi(){
        return $this->hasMany(InputAspirasi::class, 'nis', 'nis');
    }
}
