<?php

namespace Lavalite\User\Traits;

use Lavalite\User\Traits\Users\HasRoles;
use Lavalite\User\Traits\Users\HasPermissions;

/**
 * Trait HasPermission.
 */
trait CheckPermission
{
    use HasRoles, HasPermissions;

    /**
     * @var \Illuminate\Support\Collection
     */
    private $cachedPermissions;

    /**
     * @var \Illuminate\Support\Collection
     */
    private $cachedRolePermissions;

    /**
     * Returns if the current user has the given permission.
     * User permissions override role permissions.
     *
     * @param string $permission
     * @param bool   $force
     *
     * @return bool
     */
    public function hasPermission($permission, $force = false)
    {
        $permissions = $this->getAllPermissions($force)->lists('name')->toArray();

        return in_array($permission, $permissions);
    }

    /**
     * Checks for permission
     * If has superuser group automatically passes.
     *
     * @param string $permission
     * @param bool   $force
     *
     * @return bool
     */
    public function canDo($permission, $force = false)
    {
        // If has superuser role
        if ($this->isSuperUser()) {
            return true;
        }

        return $this->hasPermission($permission, $force);
    }

    /**
     * check has superuser role.
     *
     * @return bool
     */
    public function isSuperUser()
    {
        return $this->hasRole(config('user.superuser_role', 'superuser'));
    }

    /**
     * Check if the user has the given permission using
     * only his roles.
     *
     * @param string $permission
     * @param bool   $force
     *
     * @return bool
     */
    public function roleHasPermission($permission, $force = false)
    {
        $permissions = $this->getRolesPermissions($force)->lists('name')->toArray();

        return in_array($permission, $permissions);
    }

    /**
     * Retrieve all user permissions.
     *
     * @param bool $force
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllPermissions($force = false)
    {
        if (empty($this->cachedPermissions) or $force) {
            $this->cachedPermissions = $this->getFreshAllPermissions();
        }

        return $this->cachedPermissions;
    }

    /**
     * @param bool $force
     *
     * @return \Illuminate\Support\Collection
     */
    public function getRolesPermissions($force = false)
    {
        if (empty($this->cachedRolePermissions) or $force) {
            $this->cachedRolePermissions = $this->getFreshRolesPermissions();
        }

        return $this->cachedRolePermissions;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function getFreshRolesPermissions()
    {
        $roles = $this->roles()->get(['id'])->lists('id')->toArray();

        return app('user.permission')->getByRoles($roles);
    }

    /**
     * Get fresh permissions from database.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getFreshAllPermissions()
    {
        $permissionsRoles = $this->getRolesPermissions(true);

        $permissions = app('user.permission')->getActivesByUser($this);

        $permissions = $permissions->merge($permissionsRoles)
            ->map(function ($permission) {
                unset($permission->pivot, $permission->created_at, $permission->updated_at);

                return $permission;
            });

        return $permissions->toBase();
    }

    /**
     * Find a user by its id.
     *
     * @param int $id
     *
     * @return \Lavalite\User\Contracts\User
     */
    public function findById($id)
    {
        return $this->find($id);
    }
}
