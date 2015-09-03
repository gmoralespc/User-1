<?php

namespace Lavalite\User\Http\Controllers;

use Former;
use Response;
use App\Http\Controllers\AdminController as AdminController;

use Lavalite\User\Http\Requests\ViewPermissionRequest;
use Lavalite\User\Http\Requests\UpdatePermissionRequest;
use Lavalite\User\Http\Requests\StorePermissionRequest;
use Lavalite\User\Http\Requests\DeletePermissionRequest;

use Lavalite\User\Interfaces\PermissionRepositoryInterface;

/**
 *
 * @package Permissions
 */

class PermissionAdminController extends AdminController
{

    /**
     * Initialize permission controller
     * @param type PermissionRepositoryInterface $permission
     * @return type
     */
    public function __construct(PermissionRepositoryInterface $permission)
    {
        $this->model = $permission;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(ViewPermissionRequest $request)
    {
        $this->theme->prependTitle(trans('user::permission.names').' :: ');

        return $this->theme->of('user::admin.permission.index')->render();
    }

    /**
     * Return list of permission as json.
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function lists(ViewPermissionRequest $request)
    {
        $array = $this->model->json(config('user.permission.listfields'));

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
    public function show(ViewPermissionRequest $request, $id)
    {
        $permission = $this->model->findOrNew($id);

        Former::populate($permission);

        return view('user::admin.permission.show', compact('permission'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Request  $request
     * @return Response
     */
    public function create(StorePermissionRequest $request)
    {
        $permission = $this->model->findOrNew(0);
        Former::populate($permission);

        return view('user::admin.permission.create', compact('permission'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(StorePermissionRequest $request)
    {
        if ($this->model->create($request->all())) {
            return Response::json(['message' => 'Permission created sucessfully', 'type' => 'success', 'title' => 'Success'], 201);
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
    public function edit(UpdatePermissionRequest $request, $id)
    {
        $permission = $this->model->find($id);

        Former::populate($permission);

        return view('user::admin.permission.edit', compact('permission'));
    }

    /**
     * Update the specified resource.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(UpdatePermissionRequest $request, $id)
    {
        if ($row = $this->model->update($request->all(), $id)) {
            return Response::json(['message' => 'Permission updated sucessfully', 'type' => 'success', 'title' => 'Success'], 201);
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
    public function destroy(DeletePermissionRequest $request, $id)
    {
        try {
            $this->model->delete($id);
            return Response::json(['message' => 'Permission deleted sucessfully'.$id, 'type' => 'success', 'title' => 'Success'], 201);
        } catch (Exception $e) {
            return Response::json(['message' => $e->getMessage(), 'type' => 'error', 'title' => 'Error'], 400);
        }
    }
}
