<?php

namespace App\Core\Domain;

use Illuminate\Support\Facades\DB;

/**
 * Class ModelHasRolesEntity
 * @package App\Core\Domain
 */
class ModelHasRolesRepository extends AbstractRepository
{
    /**
     * ModelHasRolesRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(new ModelHasRolesEntity());
    }

    /**
     * @param int $intIdUsuario
     * @return \Illuminate\Database\Query\Builder
     */
    public function listar(int $intIdUsuario)
    {
        return DB::table('model_has_roles as mhr')->select([
            'mhr.role_id',
            'mhr.model_type',
            'mhr.model_id',
            'r.name',
        ])
            ->join('roles as r', 'r.id', '=', 'mhr.role_id')
            ->where('mhr.model_id', '=', $intIdUsuario);
    }
}
