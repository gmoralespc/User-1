<?php namespace Lavalite\User\Repositories\Eloquent;

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
     * Boots the roles repository
     *
     * @return void
     */
    public function boot()
    {
        $this->model->fillable             = config('user.role.fillable');
        $this->model->uploads              = config('user.role.uploadable');
        $this->model->uploadRootFolder     = config('user.role.upload_root_folder');
        $this->model->table                = config('user.role.table');
    }

}
