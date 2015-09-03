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
}
