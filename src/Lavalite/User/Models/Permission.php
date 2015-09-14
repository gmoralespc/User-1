<?php

namespace Lavalite\User\Models;

use Illuminate\Database\Eloquent\Model;


class Permission extends Model
{

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
        $this->table                = config('user.permission.table');
    }


}