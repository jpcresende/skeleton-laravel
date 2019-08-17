<?php


use App\Core\Domain\AbstractRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RoleRepository
 * @package App\Core\Domain
 */
class RoleRepository extends AbstractRepository
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
