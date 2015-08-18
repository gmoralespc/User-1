<?php namespace Lavalite\User\Repositories\Eloquent;

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

    /**
     * Boots the permissions repository
     *
     * @return void
     */
    public function boot()
    {
        $this->model->fillable             = config('user.permission.fillable');
        $this->model->uploads              = config('user.permission.uploadable');
        $this->model->uploadRootFolder     = config('user.permission.upload_root_folder');
        $this->model->table                = config('user.permission.table');
    }


}
