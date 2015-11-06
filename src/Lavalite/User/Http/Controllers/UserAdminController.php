<?php
namespace Lavalite\User\Http\Controllers;

use Former;
use Response;
use User;
use Lavalite\User\Models\User as UserModal;
use App\Http\Controllers\AdminController as AdminController;
use Lavalite\User\Http\Requests\UserAdminRequest;
use Lavalite\User\Interfaces\UserRepositoryInterface;
use Lavalite\User\Interfaces\RoleRepositoryInterface;
use Lavalite\User\Interfaces\PermissionRepositoryInterface;

/**
 *
 * @package User
 */

class UserAdminController extends AdminController
{
    /**
     * @var Permissions
     *
     */
    protected $permission;

    /**
     * @var roles
     *
     */
    protected $roles;

    /**
     * Initialize user controller
     * @param type UserRepositoryInterface $user
     * @return type
     */
    public function __construct(UserRepositoryInterface $user,
                                PermissionRepositoryInterface $permission,
                                RoleRepositoryInterface $roles)
    {
        $this->model = $user;
        $this->permission = $permission;
        $this->roles = $roles;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(UserAdminRequest $request, $role = null)
    {
        if ($request->wantsJson()) {
            if (!$request->has('role')) {
                $array = $this->model->json(config('user.user.listfields'));
                return ['data' => $array];
            }
            $array = $this->roles->users($request->get('role'), config('user.role.listfields'));
            return ['data' => $array];
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
    public function show(UserAdminRequest $request, UserModal $user)
    {
        if (!$user->exists) {
            if ($request->wantsJson()) {
                return [];
            }

            return view('user::admin.user.new');
        }

        if ($request->wantsJson()) {
            return $user;
        }

        $permissions  = $this->permission->groupedPermissions(true);
        $roles  = $this->roles->all();

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
        $permissions  = $this->permission->groupedPermissions(true);
        $roles  = $this->roles->all();
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
            $user->syncRoles($request->get('roles'));
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
    public function edit(UserAdminRequest $request, UserModal $user)
    {
        $permissions  = $this->permission->groupedPermissions(true);
        $roles  = $this->roles->all();
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
    public function update(UserAdminRequest $request, UserModal $user)
    {
        try {
            $attributes         = $request->all();
            $user->update($attributes);
            $user->syncRoles($request->get('roles'));
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
    public function destroy(UserAdminRequest $request, UserModal $user)
    {
        try {
            $user->delete();
            return $this->success(trans('message.success.deleted', ['Module' => trans('user::user.name')]), 200);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
