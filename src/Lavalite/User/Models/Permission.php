<?php

namespace Lavalite\User\Models;

use Lavalite\Filer\FilerTrait;
use Illuminate\Database\Eloquent\Model;


class Permission extends Model
{
    use FilerTrait;


    /**
     * Initialiaze page modal
     *
     * @param $name
     */
    public function __construct()
    {
        parent::__construct();
        $this->initialize();
    }

    /**
     * Initialize the modal variables.
     *
     * @return void
     */
    public function initialize()
    {
        $this->fillable             = config('user.permission.fillable');
        $this->uploads              = config('user.permission.uploadable');
        $this->uploadRootFolder     = config('user.permission.upload_root_folder');
        $this->table                = config('user.permission.table');
    }


}