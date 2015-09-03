<?php

namespace Lavalite\User\Http\Controllers;

use User;

use Former;
use Redirect;

use Lavalite\User\Http\Requests\ViewUserRequest;
use Lavalite\User\Http\Requests\UpdateUserRequest;
use Lavalite\User\Http\Requests\StoreUserRequest;
use Lavalite\User\Http\Requests\DeleteUserRequest;

use App\Http\Controllers\AdminController as AdminController;

class UserAdminController extends AdminController
{

    public function __construct(\Lavalite\User\Interfaces\UserRepositoryInterface $user)
    {
        $this->model    = $user;

        parent::__construct();
    }

    public function index(ViewUserRequest $request)
    {
        return $this->theme->of('user::admin.users.index')->render();
    }

    public function lists(ViewUserRequest $request, $role = null)
    {
        $array = $this->model->json($role, config('user.user.listfields'));
        return array('data' => $array);
    }

    public function show(ViewUserRequest $request, $id)
    {
        $user   = $this->model->findOrNew($id);
        $roles  = User::roles();
        $permissions  = User::permissions(true);
        Former::populate($user);
        return view('user::admin.users.show', compact('user', 'roles', 'permissions'));
    }

    public function create(StoreUserRequest $request)
    {
        $user   = $this->model->findOrNew(0);
        $roles  = User::roles();
        $permissions  = User::permissions(true);
        Former::populate($user);
        return  view('user::admin.users.create', compact('user', 'roles', 'permissions'));
    }

    public function store(StoreUserRequest $request)
    {

        try {
            $this->model->create($request->all());
            return $this->response(201, 'User created sucessfully', $row->id);
       } catch (Exception $e) {
            return $this->response(401, $e->getMessage(), $id);
        }
    }

    public function edit(UpdateUserRequest $request, $id)
    {

        $user       = $this->model->find($id);
        $roles  = User::roles();
        $permissions  = User::permissions(true);
        Former::populate($user);
        return  view('user::admin.users.edit', compact('user', 'roles', 'permissions'));
    }

    public function update(UpdateUserRequest $request, $id)
    {

        try {
            $row = $this->model->update($request->all(), $id);
            return $this->response(201, 'User updated sucessfully', $id);
        } catch (Exception $e) {
            return $this->response(401, $e->getMessage(), $id);
        }


    }

    public function destroy(DeleteUserRequest $request, $id)
    {
        try {
            $this->model->delete($id);
            return $this->response(201, 'User deleted sucessfully', $row->id);
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
