<?php

namespace Lavalite\User\Http\Controllers;

use Former;
use Response;
use Illuminate\Http\Request as Requests;
use Request;
use User;
use App\Http\Controllers\AdminController as AdminController;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Password;

use Lavalite\User\Http\Requests\UserRequest;

use Lavalite\User\Interfaces\UserRepositoryInterface;
use Lavalite\User\Interfaces\RoleRepositoryInterface;

/**
 *
 * @package Users
 */

class UserAdminController extends AdminController
{

    /**
     * Initialize user controller
     * @param type UserRepositoryInterface $user
     * @return type
     */
    public function __construct(UserRepositoryInterface $user)
    {
        $this->model = $user;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(UserRequest $request)
    {
        $this->theme->prependTitle(trans('user::user.names').' :: ');

        return $this->theme->of('user::admin.users.index')->render();
    }

    /**
     * Return list of user as json.
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function lists(UserRequest $request, RoleRepositoryInterface $roles, $role = NULL)
    {
        if (empty($role)){
            $array = $this->model->json(config('user.user.listfields'));
            return array('data' => $array);
        }

        $array = $roles->users($role, config('user.role.listfields'));
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
    public function show(UserRequest $request, $id)
    {
        $user = $this->model->findOrNew($id);
        Former::populate($user);

        $roles  = User::roles();
        $permissions  = User::permissions(true);

        return view('user::admin.users.show', compact('user', 'roles', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Request  $request
     * @return Response
     */
    public function create(UserRequest $request)
    {
        $user = $this->model->findOrNew(0);
        $permissions  = User::permissions(true);
        $roles  = User::roles();
        Former::populate($user);

        return view('user::admin.users.create', compact('user', 'roles', 'permissions'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(UserRequest $request)
    {

        if ($row = $this->model->create($request->all())) {
            return Response::json(['message' => 'User created sucessfully', 'type' => 'success', 'title' => 'Success'], 201);
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
    public function edit(UserRequest $request, $id)
    {
        $user = $this->model->find($id);

        Former::populate($user);
        $roles  = User::roles();
        $permissions  = User::permissions(true);
        return view('user::admin.users.edit', compact('user', 'roles', 'permissions'));
    }

    /**
     * Update the specified resource.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(UserRequest $request, $id)
    {
        if ($row = $this->model->update($request->all(), $id)) {
            return Response::json(['message' => 'User updated sucessfully', 'type' => 'success', 'title' => 'Success'], 201);
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
    public function destroy(UserRequest $request, $id)
    {
        try {
            $this->model->delete($id);
            return Response::json(['message' => 'User deleted sucessfully'.$id, 'type' => 'success', 'title' => 'Success'], 201);
        } catch (Exception $e) {
            return Response::json(['message' => $e->getMessage(), 'type' => 'error', 'title' => 'Error'], 400);
        }
    }

    /**
     * Update profile of logged user.
     *
     * @return Response
     */
    public function updateProfile(Authenticatable $user)
    {
        $id = $user->id;
        if ($row = $this->model->update(Request::all(), $id)) {
            return Response::json(['message' => 'Profile updated sucessfully', 'type' => 'success', 'title' => 'Success'], 201);
        } else {
            return Response::json(['message' => $e->getMessage(), 'type' => 'error', 'title' => 'Error'], 400);
        }
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Authenticatable $user, Requests $request)
    {
        $this->validate($request, [
            'password' => 'required|confirmed|min:6',
        ]);

        $password   = $request->get('password');

        $user->password = bcrypt($password);

        if ($user->save()) {
            return Response::json(['message' => 'Password changed sucessfully', 'type' => 'success', 'title' => 'Success'], 201);
        } else {
            return Response::json(['message' => $e->getMessage(), 'type' => 'error', 'title' => 'Error'], 400);
        }

    }

}