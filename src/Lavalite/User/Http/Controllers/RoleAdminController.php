<?php namespace Lavalite\User\Http\Controllers;
use Lavalite\User\Models\Role as Role;

use Former;
use Session;
use Redirect;

use Lavalite\User\Http\Requests\ViewRoleRequest;
use Lavalite\User\Http\Requests\UpdateRoleRequest;
use Lavalite\User\Http\Requests\StoreRoleRequest;
use Lavalite\User\Http\Requests\DeleteRoleRequest;

use App\Http\Controllers\AdminController as AdminController;

class RoleAdminController extends AdminController
{

    public function __construct(\Lavalite\User\Interfaces\RoleRepositoryInterface $role)
    {
        $this->model    = $role;

        parent::__construct();
    }

    public function index(ViewRoleRequest $request)
    {
        Session::forget('parent');
        return $this->theme->of('user::admin.role.index')->render();
    }

    public function lists(ViewRoleRequest $request)
    {
        $array = $this->model->json();
        foreach ($array as $key => $row){
            $array[$key]    = array_only($row, config('user.role.listfields'));
        }
        return array('data' => $array);
    }

    public function show(ViewRoleRequest $request, $id)
    {
        $role   = $this->model->findOrNew($id);
        Former::populate($role);
        return view('user::admin.role.show', compact('role'));
    }

    public function create(StoreRoleRequest $request)
    {
        $role   = $this->model->instance();
        Former::populate($role);
        return  view('user::admin.role.create', compact('role'));
    }

    public function store(StoreRoleRequest $request)
    {

        try {
            $this->model->create($request->all());
            return $this->response(201, 'Role created sucessfully', $row->id);
       } catch (Exception $e) {
            return $this->response(401, $e->getMessage(), $id);
        }
    }

    public function edit(UpdateRoleRequest $request, $id)
    {

        $role       = $this->model->find($id);
        Former::populate($role);
        return  view('user::admin.role.edit', compact('role'));
    }

    public function update(UpdateRoleRequest $request, $id)
    {

        try {
            $row = $this->model->update($id, $request->all());
            return $this->response(201, 'Role updated sucessfully', $id);
        } catch (Exception $e) {
            return $this->response(401, $e->getMessage(), $id);
        }


    }

    public function destroy(DeleteRoleRequest $request, $id)
    {
        try {
            $this->model->delete($id);
            return $this->response(201, 'Role deleted sucessfully', $row->id);
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
