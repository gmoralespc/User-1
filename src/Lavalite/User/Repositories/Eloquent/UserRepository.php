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
     * Boots the user repository
     *
     * @return void
     */
    public function boot()
    {
        $this->model->fillable             = config('user.user.fillable');
        $this->model->uploads              = config('user.user.uploadable');
        $this->model->uploadRootFolder     = config('user.user.upload_root_folder');
        $this->model->table                = config('user.user.table');
    }


}
