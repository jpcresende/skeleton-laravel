<?php


namespace App\Core\Domain;


use Illuminate\Database\Eloquent\Model;

/**
 * Class UserRepository
 * @package App\Core\Domain
 */
class UserRepository extends AbstractRepository
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
