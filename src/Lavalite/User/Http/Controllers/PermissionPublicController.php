<?php

namespace Lavalite\Permission\Http\Controllers;

use App\Http\Controllers\PublicController as CMSPublicController;

class PublicController extends CMSPublicController
{
    /**
     * Constructor
     * @param type \Lavalite\Permission\Interfaces\PermissionRepositoryInterface $permission
     *
     * @return type
     */
    public function __construct(\Lavalite\Permission\Interfaces\PermissionRepositiryInterface $permission)
    {
        $this->model = $permission;
        parent::__construct();
    }

    /**
     * Show permission's list
     *
     * @param string $slug
     *
     * @return response
     */
    protected function index($slug)
    {
        $data['permission'] = $this->model->all();

        return $this->theme->of('user::public.permission.index', $data)->render();
    }

    /**
     * Show permission
     * @param string $slug
     *
     * @return response
     */
    protected function show($slug)
    {
        $data['permission'] = $this->model->getPermission($slug);

        return $this->theme->of('user::public.permission.show', $data)->render();
    }
}
