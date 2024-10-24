<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class userModel extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $table = 'user';
    public $timestamps = false;
    protected $primaryKey = 'user_id';
    protected $fillable = ['user_username', 'user_fullname', 'user_email', 'user_password', 'user_nohp', 'user_alamat', 'user_level', 'user_profil_url'];

    protected $hidden = [
        'user_password',
    ];
    protected function casts(): array
    {
        return [
            'user_password' => 'hashed',
        ];
    }
    public function getAuthPassword()
    {
        return $this->user_password;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'role' => $this->user_level,
        ];
    }
}
