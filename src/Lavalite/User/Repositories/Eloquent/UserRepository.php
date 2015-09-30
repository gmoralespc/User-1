<?php namespace Lavalite\User\Repositories\Eloquent;

use Lavalite\User\Interfaces\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return "Lavalite\\User\\Models\\User";
    }

    /**
     * Attach role to user
     * @param type $roleName
     * @return type
     */
    public function attachRole($roleName)
    {
        return $this->model->attachRole($roleName);
    }

    /**
     * Attach permission to user
     * @param string $permissionName
     * @param array $options
     * @return type
     */
    public function attachPermission($permissionName, array $options = [])
    {
        return $this->model->attachPermission($permissionName, $options);
    }

}
