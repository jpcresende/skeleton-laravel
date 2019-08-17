<?php


namespace App\Core\Domain;


use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class Repository
 * @package App\Core\Domain
 */
abstract class AbstractRepository implements RepositoryInterface
{
    // model property on class instances
    protected $model;

    // Constructor to bind model to repo
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function find($id)
    {
        $record = DB::table($this->model->getTable())->select($this->model->getKeyName())->whereNull(['dt_exclusao'])
            ->where($this->model->getKeyName(), '=', $id)->get(0);
        if ($record->isEmpty()) {
            return null;
        }
        return $this->model->find($id);
    }

    // Get all instances of model
    public function all()
    {
        return DB::table($this->model->getTable())->select('*')->whereNull(['dt_exclusao']);
    }

    // create a new record in the database
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    // update record in the database
    public function update(array $data, $id)
    {
        $record = $this->model->find($id);
        return $record->update($data);
    }

    // remove record from the database
    public function delete($id)
    {
        $record = $this->model->find($id);
        $record->dt_exclusao = new DateTime;
        $record->id_usuario  = Auth::user()->getAuthIdentifier();
        return $record->update();
    }

    // show the record with the given id
    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    // Get the associated model
    public function getModel()
    {
        return $this->model;
    }

    // Set the associated model
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    // Eager load database relationships
    public function with($relations)
    {
        return $this->model->with($relations);
    }

    /**
     * Pesquisa por um critério
     * @param $arrData
     * @return Object
     */
    public function findBy($arrData)
    {
        return DB::table($this->model->getTable())->select(['*'])->whereNull(['dt_exclusao'])->where($arrData)->get();
    }

    /**
     * Remove um registro por um critério
     * @param $arrData
     * @return integer id do registro deletado.
     */
    public function deleteBy($arrData)
    {
        $strModel = $this->model->getTable();
        return DB::table($strModel)->where($arrData)->delete();
    }

    /**
     * Retorna um objeto pronto para rodar um SQL
     * @return \Illuminate\Database\Query\Builder
     */
    public function getQueryBuilder()
    {
        return DB::table($this->model->getTable());
    }
}