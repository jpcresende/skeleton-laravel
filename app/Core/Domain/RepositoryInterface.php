<?php


namespace App\Core\Domain;


/**
 * Interface RepositoryInterface
 * @package App\Core\Domain
 */
interface RepositoryInterface
{
    public function all();

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function show($id);

    public function findBy($id);

    public function getQueryBuilder();

    public function deleteBy($arrData);
}