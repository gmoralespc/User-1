<?php
namespace Lavalite\User\Http\Controllers;

use Former;
use Response;
use User;
use App\Http\Controllers\AdminController as AdminController;

use Lavalite\User\Http\Requests\UserAdminRequest;
use Lavalite\User\Interfaces\UserRepositoryInterface;
use Lavalite\User\Interfaces\RoleRepositoryInterface;

/**
 *
 * @package User
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
    public function index(UserAdminRequest $request, RoleRepositoryInterface $roles, $role = NULL)
    {
        if($request->wantsJson()){
            if (!$request->has('role')){
                $array = $this->model->json(config('user.user.listfields'));
                return array('data' => $array);
            }
            $array = $roles->users($request->get('role'), config('user.role.listfields'));
            return array('data' => $array);
        }

        $this->theme->prependTitle(trans('user::user.names').' :: ');

        return $this->theme->of('user::admin.user.index')->render();
    }


    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @param  int  $id
     *
     * @return Response
     */
    public function show(UserAdminRequest $request, $id)
    {
        $user = $this->model->find($id);

        if (empty($user)) {

            if($request->wantsJson())
                return [];

            return view('user::admin.user.new');
        }

        if($request->wantsJson())
            return $user;

        $permissions  = User::permissions(true);
        $roles  = User::roles();

        Former::populate($user);

        return view('user::admin.user.show', compact('user', 'roles', 'permissions'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Request  $request
     * @return Response
     */
    public function create(UserAdminRequest $request)
    {
        $user = $this->model->findOrNew(0);
        $permissions  = User::permissions(true);
        $roles  = User::roles();
        Former::populate($user);

        return view('user::admin.user.create', compact('user', 'roles', 'permissions'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(UserAdminRequest $request)
    {
        try {
            $attributes         = $request->all();
            $user       = $this->model->create($attributes);
            return $this->success(trans('messages.success.created', ['Module' => trans('user::user.name')]));
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
    public function edit(UserAdminRequest $request, $id)
    {
        $user = $this->model->find($id);
        $roles  = User::roles();
        $permissions  = User::permissions(true);
        Former::populate($user);

        return view('user::admin.user.edit', compact('user', 'roles', 'permissions'));
    }

    /**
     * Update the specified resource.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(UserAdminRequest $request, $id)
    {
        try {
            $attributes         = $request->all();
            $user       = $this->model->update($attributes, $id);
            return $this->success(trans('messages.success.updated', ['Module' => trans('user::user.name')]));
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
    public function destroy(UserAdminRequest $request, $id)
    {
        try {
            $this->model->delete($id);
            return $this->success(trans('message.success.deleted', ['Module' => trans('user::user.name')]), 200);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

}
