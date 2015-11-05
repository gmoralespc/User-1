<?php

namespace Lavalite\User\Repositories\Eloquent;

use Lavalite\User\Interfaces\PermissionRepositoryInterface;
use Carbon\Carbon;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "Lavalite\\User\\Models\\Permission";
    }

    /**
     * Returns all users with given role.
     *
     * @return mixed
     */
    public function groupedPermissions($grouped = false)
    {
        $result =  $this->model->orderBy('name')->lists('readable_name', 'name')->toArray();

        $array = [];

        foreach ($result as $key => $value) {
            $key = explode('.', $key, 2);
            @$array[$key[0]][$key[1]] = $value;
        }
        return $array;
    }


    /**
     * Create a new permission using the given name.
     *
     * @param string $permissionName
     * @param string $readableName
     *
     * @throws PermissionExistsException
     *
     * @return Permission
     */
    public function createPermission($permissionName, $readableName = null)
    {
        if (! is_null($this->findByName($permissionName))) {
            throw new PermissionExistsException('The permission '.$permissionName.' already exists'); // TODO: add translation support
        }

        // Do we have a display_name set?
        $readableName = is_null($readableName) ? $permissionName : $readableName;

        return $permission = $this->model->create([
            'name'          => $permissionName,
            'readable_name' => $readableName,
        ]);
    }

    /**
     * @param array $rolesIds
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByRoles(array $rolesIds)
    {
        return $this->model->whereHas('roles', function ($query) use ($rolesIds) {
            $query->whereIn('id', $rolesIds);
        })->get();
    }

    /**
     * @param $user
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActivesByUser($user)
    {
        $table = $user->permissions()->getTable();

        return $user->permissions()
            ->where($table.'.value', true)
            ->where(function ($q) use ($table) {
                $q->where($table.'.expires', '>=', Carbon::now());
                $q->orWhereNull($table.'.expires');
            })
            ->get();
    }

}
