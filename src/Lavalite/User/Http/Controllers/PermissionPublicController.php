<?php namespace Lavalite\User\Controllers;

use App;
use Lang;
use Input;
use Sentry;
use Config;

class PublicController extends \PublicController
{

    /**
     * permission instance.
     *
     * @var \Permissions\permission\Permissions
     */
    protected $permission;


    public function __construct(\Lavalite\User\Interfaces\PermissionInterface $permission)
    {
        $this->permission      = $permission;
        parent::__construct();
    }

    public function index()
    {

        $permissions   =  $this->permission->paginate(10);
        $this->theme->prependTitle(trans('user::permission.names') . ' :: ');
        return $this->theme->of('user::permission.index',compact(permissions))->render();
    }



    public function show($slug)
    {
        $data['permission']   = $this->permission->findBySlug($slug);

        $this->theme->prependTitle(trans('user::permission.names') . ' :: ');

        return $this->theme->of('user::permission.show', $data)->render();
    }

}
