<?php

namespace Lavalite\Role\Http\Controllers;

use App\Http\Controllers\PublicController as CMSPublicController;

class PublicController extends CMSPublicController
{
    /**
     * Constructor
     * @param type \Lavalite\Role\Interfaces\RoleRepositoryInterface $role
     *
     * @return type
     */
    public function __construct(\Lavalite\Role\Interfaces\RoleRepositiryInterface $role)
    {
        $this->model = $role;
        parent::__construct();
    }

    /**
     * Show role's list
     *
     * @param string $slug
     *
     * @return response
     */
    protected function index($slug)
    {
        $data['role'] = $this->model->all();

        return $this->theme->of('user::public.role.index', $data)->render();
    }

    /**
     * Show role
     * @param string $slug
     *
     * @return response
     */
    protected function show($slug)
    {
        $data['role'] = $this->model->getRole($slug);

        return $this->theme->of('user::public.role.show', $data)->render();
    }
}
