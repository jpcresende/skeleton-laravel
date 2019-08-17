<?php


use App\Core\Domain\AbstractRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PermissionRepository
 * @package App\Core\Domain
 */
class PermissionRepository extends AbstractRepository
{
    /**
     * UserRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}
