<?php
namespace Lavalite\User\Http\Controllers;

use Former;
use Response;
use App\Http\Controllers\AdminController as AdminController;

use Lavalite\User\Http\Requests\PermissionAdminRequest;
use Lavalite\User\Interfaces\PermissionRepositoryInterface;

/**
 *
 * @package Permission
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
    public function index(PermissionAdminRequest $request)
    {
        if($request->wantsJson()){

            $array = $this->model->json();
            foreach ($array as $key => $row) {
                $array[$key] = array_only($row, config('user.permission.listfields'));
            }

            return array('data' => $array);
        }

        $this->theme->prependTitle(trans('user::permission.names').' :: ');

        return $this->theme->of('user::admin.permission.index')->render();
    }

    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @param  int  $id
     *
     * @return Response
     */
    public function show(PermissionAdminRequest $request, $id)
    {
        $permission = $this->model->find($id);

        if (empty($permission)) {

            if($request->wantsJson())
                return [];

            return view('user::admin.permission.new');
        }

        if($request->wantsJson())
            return $permission;

        Former::populate($permission);

        return view('user::admin.permission.show', compact('permission'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Request  $request
     * @return Response
     */
    public function create(PermissionAdminRequest $request)
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
    public function store(PermissionAdminRequest $request)
    {
        try {
            $attributes         = $request->all();
            $permission       = $this->model->create($attributes);
            return $this->success(trans('messages.success.created', ['Module' => trans('user::permission.name')]));
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function edit(PermissionAdminRequest $request, $id)
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
    public function update(PermissionAdminRequest $request, $id)
    {
        try {
            $attributes         = $request->all();
            $permission       = $this->model->update($attributes, $id);
            return $this->success(trans('messages.success.updated', ['Module' => trans('user::permission.name')]));
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Remove the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(PermissionAdminRequest $request, $id)
    {
        try {
            $this->model->delete($id);
            return $this->success(trans('message.success.deleted', ['Module' => trans('user::permission.name')]), 200);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

}