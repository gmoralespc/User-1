<?php

namespace Lavalite\User\Models;

use Lavalite\Filer\FilerTrait;
use Illuminate\Database\Eloquent\Model;


class Role extends Model
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
        $this->fillable             = config('user.role.fillable');
        $this->uploads              = config('user.role.uploadable');
        $this->uploadRootFolder     = config('user.role.upload_root_folder');
        $this->table                = config('user.role.table');
    }
    /**
     * The users that belong to the role.
     */
    public function users(){
        return $this->belongsToMany('Lavalite\User\Models\User');
    }


}