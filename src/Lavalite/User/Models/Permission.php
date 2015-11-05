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

    /**
     * Many-to-many permission-role relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('Lavalite\User\Models\Role')->withPivot('value', 'expires');
    }

    /**
     * Many-to-many permission-user relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('Lavalite\User\Models\User')->withPivot('value', 'expires');
    }



}