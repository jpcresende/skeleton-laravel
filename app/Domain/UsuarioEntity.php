<?php

namespace App\Domain;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class UsuarioEntity
 * @package App\Domain
 */
class UsuarioEntity extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * @var string
     */
    protected $table = 'tb_usuario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
