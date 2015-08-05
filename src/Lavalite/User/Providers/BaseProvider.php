<?php namespace Lavalite\User\Providers;

use Lavalite\User\Interfaces\BaseInterface;

class BaseProvider implements BaseInterface
{
   /**
     * @var Model
     */
    protected $model;

    public function all()
    {
        return $this->model->all();
    }

    public function json()
    {
        return  $this->model->get()->toArray();
    }

    public function create(array $array)
    {
        $row =  $this->instance($array);
        $row -> fill($array);
        $row -> save();
        return $row;
    }

    public function update($id, $array)
    {
        $row =  $this->model->find($id);
        $row -> fill($array);
        $row -> save();
        return $row;
    }

    public function findOrNew($id){
        return  $this->model->findOrNew($id);
    }

    public function find($id)
    {
        return  $this->model->find($id);
    }

    public function delete($id)
    {
        $this -> model -> find($id) -> delete();
    }


    public function destroy($id)
    {
        $this -> model -> destroy($ids);
    }

    public function instance($data = array())
    {
        return new $this -> model($data);
    }
}
