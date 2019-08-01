<?php

namespace App\Core\Domain;

use Illuminate\Database\Eloquent\Model;

class PermissionEntity extends Model
{
    /**
     * @var string
     */
    protected $table = 'permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'guard_name',
    ];
}
