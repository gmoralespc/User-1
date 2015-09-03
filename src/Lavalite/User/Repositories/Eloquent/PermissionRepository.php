<?php

namespace Lavalite\User\Repositories\Eloquent;

use Lavalite\User\Interfaces\PermissionRepositoryInterface;

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
}
