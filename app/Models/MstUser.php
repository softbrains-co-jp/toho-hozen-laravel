<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class MstUser extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROLE_USER = 1;
    public const ROLE_TOHO = 2;
    public const ROLE_ADMIN = 3;

    protected $table = 'mst_users';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
