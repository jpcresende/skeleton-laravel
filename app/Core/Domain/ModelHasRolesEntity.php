<?php

namespace App\Core\Domain;

use Illuminate\Database\Eloquent\Model;

class ModelHasRolesEntity extends Model
{
    const GUARD_NAME = 'api';

    /**
     * @var string
     */
    protected $table = 'model_has_roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id', 'model_type', 'model_id',
    ];
}
