<?php

namespace Lavalite\User\Repositories\Eloquent;

use Lavalite\User\Interfaces\RoleRepositoryInterface;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "Lavalite\\User\\Models\\Role";
    }

    /**
     * Retrive users list based on role
     *
     * @param string $role
     * @param array $columns
     * @return mixed
     */
    public function users($role = NULL, $columns = array('*'))
    {
        $results = $this->model->with('users')->where('name', $role)->first($columns);

        $this->resetModel();

        if (isset($results->users))
            return $results->users;

        return array();
    }

}
