<?php

namespace Lavalite\User\Models;

use Illuminate\Database\Eloquent\Model;


class Role extends Model
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
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'permissions'   => 'array'
    ];


    /**
     * Initialize the modal variables.
     *
     * @return void
     */
    public function initialize()
    {
        $this->fillable             = config('user.role.fillable');
        $this->table                = config('user.role.table');
    }

    /**
     * The users that belong to the role.
     */
    public function users(){
        return $this->belongsToMany('Lavalite\User\Models\User');
    }

}