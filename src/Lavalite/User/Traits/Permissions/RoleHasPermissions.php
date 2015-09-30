<?php

namespace Lavalite\User\Traits\Permissions;

use Illuminate\Database\Eloquent\Model;
use Lavalite\User\Pivots\PermissionRolePivot;

/**
 * Trait RoleHasPermissions.
 */
trait RoleHasPermissions
{
    use InteractsWithPermissions;

    /**
     * Many-to-many permission-user relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        $permissionModel = config('user.permission.model');

        return $this->belongsToMany($permissionModel)->withPivot('value', 'expires');
    }

    /**
     * @param Model  $parent
     * @param array  $attributes
     * @param string $table
     * @param bool   $exists
     *
     * @return PermissionRolePivot|\Illuminate\Database\Eloquent\Relations\Pivot
     */
    public function newPivot(Model $parent, array $attributes, $table, $exists)
    {
        $permissionModel = app()['config']->get('user.permission.model');

        if ($parent instanceof $permissionModel) {
            return new PermissionRolePivot($parent, $attributes, $table, $exists);
        }

        return parent::newPivot($parent, $attributes, $table, $exists);
    }
}
