<?php

namespace Lavalite\User\Http\Controllers;

use Former;
use Response;
use App\Http\Controllers\AdminController as AdminController;

use Lavalite\User\Http\Requests\RoleRequest;
use Lavalite\User\Interfaces\RoleRepositoryInterface;

/**
 *
 * @package Roles
 */

class RoleAdminController extends AdminController
{

    /**
     * Initialize role controller
     * @param type RoleRepositoryInterface $role
     * @return type
     */
    public function __construct(RoleRepositoryInterface $role)
    {
        $this->model = $role;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(RoleRequest $request)
    {
        $this->theme->prependTitle(trans('user::role.names').' :: ');

        return $this->theme->of('user::admin.role.index')->render();
    }

    /**
     * Return list of role as json.
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function lists(RoleRequest $request)
    {
        $array = $this->model->json();
        foreach ($array as $key => $row) {
            $array[$key] = array_only($row, config('user.role.listfields'));
        }

        return array('data' => $array);
    }

    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @param  int  $id
     *
     * @return Response
     */
    public function show(RoleRequest $request, $id)
    {
        $role = $this->model->findOrNew($id);

        Former::populate($role);

        return view('user::admin.role.show', compact('role'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Request  $request
     * @return Response
     */
    public function create(RoleRequest $request)
    {
        $role = $this->model->findOrNew(0);
        Former::populate($role);

        return view('user::admin.role.create', compact('role'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(RoleRequest $request)
    {
        if ($row = $this->model->create($request->all())) {
            return Response::json(['message' => 'Role created sucessfully', 'type' => 'success', 'title' => 'Success'], 201);
        } else {
            return Response::json(['message' => $e->getMessage(), 'type' => 'error', 'title' => 'Error'], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function edit(RoleRequest $request, $id)
    {
        $role = $this->model->find($id);

        Former::populate($role);

        return view('user::admin.role.edit', compact('role'));
    }

    /**
     * Update the specified resource.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(RoleRequest $request, $id)
    {
        if ($row = $this->model->update($request->all(), $id)) {
            return Response::json(['message' => 'Role updated sucessfully', 'type' => 'success', 'title' => 'Success'], 201);
        } else {
            return Response::json(['message' => $e->getMessage(), 'type' => 'error', 'title' => 'Error'], 400);
        }
    }

    /**
     * Remove the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(RoleRequest $request, $id)
    {
        try {
            $this->model->delete($id);
            return Response::json(['message' => 'Role deleted sucessfully'.$id, 'type' => 'success', 'title' => 'Success'], 201);
        } catch (Exception $e) {
            return Response::json(['message' => $e->getMessage(), 'type' => 'error', 'title' => 'Error'], 400);
        }
    }
}
