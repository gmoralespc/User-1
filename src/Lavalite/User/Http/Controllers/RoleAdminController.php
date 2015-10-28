<?php
namespace Lavalite\User\Http\Controllers;

use Former;
use Response;
use App\Http\Controllers\AdminController as AdminController;
use Lavalite\User\Http\Requests\RoleAdminRequest;
use Lavalite\User\Interfaces\RoleRepositoryInterface;

/**
 *
 * @package Role
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
    public function index(RoleAdminRequest $request)
    {
        if($request->wantsJson()){

            $array = $this->model->json();
            foreach ($array as $key => $row) {
                $array[$key] = array_only($row, config('user.role.listfields'));
            }

            return array('data' => $array);
        }

        $this->theme->prependTitle(trans('user::role.names').' :: ');

        return $this->theme->of('user::admin.role.index')->render();
    }

    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @param  int  $id
     *
     * @return Response
     */
    public function show(RoleAdminRequest $request, $id)
    {
        $role = $this->model->find($id);

        if (empty($role)) {
            if ($request->wantsJson()) {
                return [];
            }

            return view('user::admin.role.new');
        }

        if ($request->wantsJson()) {
            return $role;
        }

        Former::populate($role);

        return view('user::admin.role.show', compact('role'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Request  $request
     * @return Response
     */
    public function create(RoleAdminRequest $request)
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
    public function store(RoleAdminRequest $request)
    {
        try {
            $attributes         = $request->all();
            $role       = $this->model->create($attributes);
            return $this->success(trans('messages.success.created', ['Module' => trans('user::role.name')]));
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
    public function edit(RoleAdminRequest $request, $id)
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
    public function update(RoleAdminRequest $request, $id)
    {
        try {
            $attributes         = $request->all();
            $role       = $this->model->update($attributes, $id);
            return $this->success(trans('messages.success.updated', ['Module' => trans('user::role.name')]));
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
    public function destroy(RoleAdminRequest $request, $id)
    {
        try {
            $this->model->delete($id);
            return $this->success(trans('message.success.deleted', ['Module' => trans('user::role.name')]), 200);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
