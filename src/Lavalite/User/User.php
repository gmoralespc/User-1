<?php namespace Lavalite\User;

/**
 *
 * Part of the Lavalite package.
 *
 *
 * @package    User
 * @version    5.1.0
 */

use Auth;
use Former;
use Illuminate\Contracts\Foundation\Application;
use Lavalite\User\Interfaces\UserRepositoryInterface;
use Lavalite\User\Interfaces\RoleRepositoryInterface;
use Lavalite\User\Interfaces\PermissionRepositoryInterface;

/**
 * User wrapper class.
 */
class User
{
    /**
     * @var Application  variable
     */
    protected $app;

    /**
     * @var User repository variable
     */
    protected $user;

    /**
     * @var permission repository variable
     */
    protected $permission;

    /**
     * @var role repository variable
     */
    protected $role;

    /**
     *  Initialize User
     *
     * @param \Lavalite\User\Interfaces\UserInterface $user
     * @param \Lavalite\User\Interfaces\RoleInterface $role
     * @param \Lavalite\User\Interfaces\PermissionRepositoryInterface $permission
     *
     */

    public function __construct(Application $app,
                                UserRepositoryInterface $user,
                                RoleRepositoryInterface $role,
                                PermissionRepositoryInterface $permission)
    {
        $this->app          = $app;
        $this->user         = $user;
        $this->role         = $role;
        $this->permission   = $permission;
    }

    /**
     * Registers a user by giving the required credentials
     * and an optional flag for whether to activate the user.
     *
     * @param  array  $credentials
     * @param  bool   $activate
     * @return \Lavalite\User\Interfaces\UserInterface
     */
    public function create(array $credentials, $active = false)
    {
        $credentials = $credentials + ['active' => $active];
        return $this->user->create($credentials);
    }

    /**
     * Attempts to authenticate the given user
     * according to the passed credentials.
     *
     * @param  array  $credentials
     * @param  bool   $remember
     * @return bool
     */
    public function attempt(array $credentials, $remember = false)
    {
        return $this->app['user.auth']->attempt($credentials, $remember);
    }

    /**
     * Alias for authenticating with the remember flag checked.
     *
     * @param  array  $credentials
     * @return bool
     */
    public function attemptAndRemember(array $credentials)
    {
        return $this->app['user.auth']->attempt($credentials, true);
    }

    /**
     * Check to see if the user is logged in and activated, and hasn't been banned or suspended.
     *
     * @return bool
     */
    public function check()
    {
        return $this->app['user.auth']->check();
    }

    /**
     * Logs in the given user and sets properties
     * in the session.
     *
     * @param  array $credentials
     * @param  bool  $remember
     * @return void
     */
    public function login(Authenticatable $user, $remember = false)
    {
        // Authentication attempt usng laravel native auth class
        return $this->app['user.auth']->attempt($user, $remember);
    }

    /**
     * Logs in user for a single request
     * in the session.
     *
     * @param  array $credentials
     * @return bool
     */
    public function once(array $user)
    {
        return $this->app['user.auth']->once($user);
    }

    /**
     * Logs the current user out.
     *
     * @return void
     */
    public function logout()
    {
        $this->app['user.auth']->logout();
    }

    /**
     * Returns the current user being used by Lavalite, if any.
     *
     * @return Laravel user object
     */
    public function user()
    {
        // We will lazily attempt to load our user
        return $this->app['user.auth']->user();
    }

    /**
     * Get the current authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function getUser()
    {
        return $this->app['user.auth']->user();
    }

    /**
     * Check if the authenticated user has the given permission.
     *
     * @param string $permission
     * @param bool   $force
     *
     * @return bool
     */
    public function hasPermission($permission, $force = false)
    {
        if (! is_null($this->getUser())) {
            return $this->getUser()->hasPermission($permission, $force);
        }

        return false;
    }

    /**
     * Check if the authenticated user has the given permission.
     *
     * @param string $permission
     * @param bool   $force
     *
     * @return bool
     */
    public function can($permission, $force = false)
    {
        if (! is_null($this->getUser())) {
            return $this->getUser()->canDo($permission, $force);
        }

        return false;
    }

    /**
     * Check if the authenticated user has the given permission
     * using only the roles.
     *
     * @param string $permission
     * @param bool   $force
     *
     * @return bool
     */
    public function roleHasPermission($permission, $force = false)
    {
        if (! is_null($this->getUser())) {
            return $this->getUser()->roleHasPermission($permission, $force);
        }

        return false;
    }

    /**
     * Return if the authenticated user has the given role.
     *
     * @param string $roleName
     *
     * @return bool
     */
    public function hasRole($roleName)
    {
        if (! is_null($this->getUser())) {
            return $this->getUser()->hasRole($roleName);
        }

        return false;
    }

    /**
     * Return if the authenticated user has any of the given roles.
     *
     * @param string $roles
     *
     * @return bool
     */
    public function hasRoles($roles)
    {
        if (! is_null($this->getUser())) {
            return $this->getUser()->hasRoles($roles);
        }

        return false;
    }

    /**
     * Return if the authenticated user has the given role.
     *
     * @param string|array $roleName
     *
     * @return bool
     */
    public function is($roleName)
    {
        if (is_array($roleName)) {
            return $this->hasRoles($roleName);
        }

        return $this->hasRole($roleName);
    }

    /**
     * Check if a role with the given name exists.
     *
     * @param string $roleName
     *
     * @return bool
     */
    public function roleExists($roleName)
    {
        return $this->role->findByName($roleName) !== null;
    }

    /**
     * Check if a permission with the given name exists.
     *
     * @param string $permissionName
     *
     * @return bool
     */
    public function permissionExists($permissionName)
    {
        return $this->permission->findByName($permissionName) !== null;
    }

    /**
     * Get the role with the given name.
     *
     * @param string $roleName
     *
     * @return \Artesaos\Defender\Role|null
     */
    public function findRole($roleName)
    {
        return $this->role->findByName($roleName);
    }

    /**
     * * Find a role by its id.
     *
     * @param int $roleId
     *
     * @return mixed
     */
    public function findRoleById($roleId)
    {
        return $this->role->find($roleId);
    }

    /**
     * Get the permission with the given name.
     *
     * @param string $permissionName
     *
     * @return \Artesaos\Defender\Permission|null
     */
    public function findPermission($permissionName)
    {
        return $this->permission->findByName($permissionName);
    }

    /**
     * Find a permission by its id.
     *
     * @param int $permissionId
     *
     * @return \Artesaos\Defender\Permission|null
     */
    public function findPermissionById($permissionId)
    {
        return $this->permission->find($permissionId);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function permissionsList()
    {
        return $this->permission->getList('name', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function rolesList()
    {
        return $this->role->getList('name', 'id');
    }

    /**
     * Create a new role.
     * Uses a repository to actually create the role.
     *
     * @param string $roleName
     *
     * @return \Artesaos\Defender\Role
     */
    public function createRole($roleName)
    {
        return $this->role->create(['name' => $roleName]);
    }

    /**
     * @param string $permissionName
     * @param string $readableName
     *
     * @return Permission
     */
    public function createPermission($permissionName, $readableName = null)
    {
        return $this->permission->create(['name' => $permissionName, 'readable_name' => $readableName]);
    }

    /**
     * @return Javascript
     */
    public function javascript()
    {
        if (! $this->javascript) {
            $this->javascript = new Javascript($this);
        }

        return $this->javascript;
    }

    /**
     * Returns the specific details of current user.
     *
     * @return mixed
     */
    public function users($field)
    {
        return  $this->user()->$field;
    }

    /**
     * Returns all roles avilable .
     *
     * @return mixed
     */
    public function roles()
    {
        return  $this->role->all(['id', 'name']);
    }

    /**
     * Returns all roles avilable .
     *
     * @return mixed
     */
    public function usersWithRole($role)
    {
        return  $this->role->users($role);
    }

    /**
     * Return the profile update page.
     *
     * @return Response
     */
    public function profile($mode)
    {
        $user = $this->user->find(User::users('id'));
        Former::populate($user);
        return view('user::admin.user.profile', compact('user'));
    }

    /**
     * Return change password form.
     *
     * @return Response
     */
    public function password($mode)
    {
        $user = $this->user->find(User::users('id'));
        return view('user::admin.user.password', compact('user'));
    }


    /**
     * Return the count of records.
     *
     * @return Response
     */
    public function count()
    {
        return 0;
    }
}
