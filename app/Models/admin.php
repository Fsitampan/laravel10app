<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;
    protected $table = 'admin';
    public $incrementing = false;
    protected $primaryKey = 'username';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'username',
        'password',
    ];
    

    public function getAuthIdentifierName(){
        return 'username';
    }
    public function getAuthIdentifier(){
        return $this->username;
    }
    public function getAuthPassword(){
        return $this->password;
    }

}
