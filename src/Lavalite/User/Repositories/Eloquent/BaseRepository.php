<?php namespace Lavalite\User\Repositories\Eloquent;

use Lavalite\User\Interfaces\BaseInterface;

abstract class BaseRepository implements BaseInterface
{
    /**
     * @var Model
     */
    protected $model;

    public function all()
    {
        return $this->model->all();
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function update($id, $data)
    {
        $instance = $this->model->find($id);

        $instance->fill($data);

        return $instance->save();
    }

    public function save()
    {
        return $this->model->save();
    }

    public function find($id)
    {
        return $this->model
                    ->whereId($id)
                    ->first();
    }

    public function first($field, $value)
    {
        return $this->model
                    ->where($field, $value)
                    ->first();
    }

    public function orderBy($field, $order)
    {
        return $this->model
                    ->orderBy($field, $order)
                    ->get();
    }

    public function orderByAndPaginate($field, $order, $per_page)
    {
        return $this->model
                    ->orderBy($field, $order)
                    ->paginate($per_page);
    }

    public function paginate($per_page)
    {
        return $this->model->paginate($per_page);
    }



    public function delete($id)
    {
        $this->model->find($id)->delete();
    }

    /**
     * returns the current Model to Manager
     *
     * @return object
     */
    private function getModel()
    {
        return $this->model;
    }

}
