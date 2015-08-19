<?php namespace Lavalite\User\Http\Controllers;
use Lavalite\User\Models\Permission as Permission;

use Former;
use Session;
use Redirect;

use Lavalite\User\Http\Requests\ViewPermissionRequest;
use Lavalite\User\Http\Requests\UpdatePermissionRequest;
use Lavalite\User\Http\Requests\StorePermissionRequest;
use Lavalite\User\Http\Requests\DeletePermissionRequest;

use App\Http\Controllers\AdminController as AdminController;

class PermissionAdminController extends AdminController
{

    public function __construct(\Lavalite\User\Interfaces\PermissionRepositoryInterface $permission)
    {
        $this->model    = $permission;

        parent::__construct();
    }

    public function index(ViewPermissionRequest $request)
    {
        Session::forget('parent');
        return $this->theme->of('user::admin.permission.index')->render();
    }

    public function lists(ViewPermissionRequest $request)
    {
        $array = $this->model->json();
        foreach ($array as $key => $row){
            $array[$key]    = array_only($row, config('user.permission.listfields'));
        }
        return array('data' => $array);
    }

    public function show(ViewPermissionRequest $request, $id)
    {
        $permission   = $this->model->findOrNew($id);
        Former::populate($permission);
        return view('user::admin.permission.show', compact('permission'));
    }

    public function create(StorePermissionRequest $request)
    {
        $permission   = $this->model->findOrNew(0);
        Former::populate($permission);
        return  view('user::admin.permission.create', compact('permission'));
    }

    public function store(StorePermissionRequest $request)
    {

        try {
            $this->model->create($request->all());
            return $this->response(201, 'Permission created sucessfully', $row->id);
       } catch (Exception $e) {
            return $this->response(401, $e->getMessage(), $id);
        }
    }

    public function edit(UpdatePermissionRequest $request, $id)
    {

        $permission       = $this->model->find($id);
        Former::populate($permission);
        return  view('user::admin.permission.edit', compact('permission'));
    }

    public function update(UpdatePermissionRequest $request, $id)
    {

        try {
            $row = $this->model->update($id, $request->all());
            return $this->response(201, 'Permission updated sucessfully', $id);
        } catch (Exception $e) {
            return $this->response(401, $e->getMessage(), $id);
        }


    }

    public function destroy(DeletePermissionRequest $request, $id)
    {
        try {
            $this->model->delete($id);
            return $this->response(201, 'Permission deleted sucessfully', $row->id);
        } catch (Exception $e) {
            return $this->response(401, $e->getMessage(), $row->id);
        }
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function response($code, $message, $id)
    {
        return Response::json(array(
                    'code'      => $code,
                    'id'        => $id,
                    'message'   => $message
                ), $code);
    }
}
