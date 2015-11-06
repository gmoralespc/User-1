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
    public function model()
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
    public function users($role = null, $columns = ['*'])
    {
        $results = $this->model->with('users')->where('name', $role)->first($columns);

        $this->resetModel();

        if (isset($results->users)) {
            return $results->users;
        }

        return [];
    }

    /**
     * Create a new role with the given name.
     *
     * @param $roleName
     *
     * @throws \Exception
     *
     * @return Role
     */
    public function createRole($roleName)
    {
        if (! is_null($this->findByName($roleName))) {
            // TODO: add translation support
            throw new RoleExistsException('A role with the given name already exists');
        }
        return $role = $this->model->create(['name' => $roleName]);
    }
}
