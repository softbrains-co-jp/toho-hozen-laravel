<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class MstUser extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROLE_USER = 1;
    public const ROLE_TOHO = 2;
    public const ROLE_ADMIN = 3;
    public const ROLES = [
        self::ROLE_USER => '一般ユーザ',
        self::ROLE_TOHO => '東邦ユーザ',
        self::ROLE_ADMIN => '管理者',
    ];

    protected $table = 'mst_users';

    protected $guarded = [
        'id'
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

    /**
     * trader_cd 仮想プロパティ
     */
    protected function traderCd(): Attribute
    {
        return Attribute::make(
            get: fn () => substr($this->login_id, 0, 3),
        );
    }
}
