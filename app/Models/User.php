<?php

namespace App\Models;

use App\Models\Baidang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory;
    const ROLE_USER = 'user';
    const ROLE_ADMIN = 'admin';
    const ROLE_NHANVIEN = 'nhanvien';
    const ROLE_CHUNHA = 'chunha';

    const ROLE_MOIGIOI = 'moigioi';

    protected $table="users";
    protected $fillable = ['name', 'email', 'password', 'phone', 'avatar', 'role','language','link_zalo','link_tele','quoctich'];

    public function baidangs()
    {
        return $this->hasMany(Baidang::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
