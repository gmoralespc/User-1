<?php namespace Lavalite\User;

/**
 *
 * Part of the Lavalite package.
 *
 *
 * @package    User
 * @version    5.1.0
 */

use Theme;
use Auth;
use URL;
use Artesaos\Defender\Facades\Defender as Defender;

/**
 * User wrapper class.
 */
class User {

	/**
	 * @var user
	 */
    protected $user;

	/**
	 * @var role
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

    public function __construct(\Lavalite\User\Interfaces\UserRepositoryInterface $user,
    							\Lavalite\User\Interfaces\RoleRepositoryInterface $role,
    							\Lavalite\User\Interfaces\PermissionRepositoryInterface $permission)
    {
        $this->user     	= $user;
        $this->role     	= $role;
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
	public function create(array $credentials, $activate = false)
	{
		$credentials = $credentials + ['active' => $active];
		\Lavalite\User\Models::create($credentials);
		return Auth::user();
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
		return Auth::attempt($credentials, $remember);
	}

	/**
	 * Alias for authenticating with the remember flag checked.
	 *
	 * @param  array  $credentials
	 * @return bool
	 */
	public function attemptAndRemember(array $credentials)
	{
		return Auth::attempt($credentials, true);
	}

	/**
	 * Check to see if the user is logged in and activated, and hasn't been banned or suspended.
	 *
	 * @return bool
	 */
	public function check()
	{
		return Auth::check();
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
		return Auth::attempt($user, $remember);
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
		return Auth::once($user);
	}

	/**
	 * Logs the current user out.
	 *
	 * @return void
	 */
	public function logout()
	{
		Auth::logout();
	}

	/**
	 * Returns the current user being used by Lavalite, if any.
	 *
	 * @return Laravel user object
	 */
	public function user()
	{
		// We will lazily attempt to load our user
		return Auth::user();
	}

	/**
	 * Check if the logged user has the $permission.
	 *
	 * @param  string $permission
	 *
	 * @return bool
	 */
	public function can($permission)
	{
		if (is_string($permission))
			return Defender::can($permission);

		if (is_array($permission))
			return $this->canAny($permission);
	}

	/**
	 * Check if the logged user has any of the $permission.
	 *
	 * @param  array $permissions
	 *
	 * @return bool
	 */

	public function canAny(array $permissions)
	{
		if (is_array($permissions) and count($permissions) > 0) {
            foreach ($permissions as $permission) {
                if(Defender::can($permission)) return true;
            }
        }
        return false;
	}

	/**
	 * Check if the logged user has the $permission checking only the role permissions.
	 *
	 * @param  array $permissions
	 *
	 * @return bool
	 */

	public function canWithRolePermissions(array $permissions)
	{
		return Defender::canWithRolePermissions($permission);
	}

	/**
	 * Check whether the current user belongs to the role.
	 *
	 * @param  string $roleName
	 *
	 * @return bool
	 */

	public function is($roleName)
	{
        return Defender::is($roleName);
	}

	/**
	 * Check whether the current user belongs to the role.
	 *
	 * @param  string $roleName
	 *
	 * @return bool
	 */

	public function hasRole($roleName)
	{
        return Defender::hasRole($roleName);
	}

	/**
	 * Check if the role $roleName exists in the database.
	 *
	 * @param  string $roleName
	 *
	 * @return bool
	 */

	public function roleExists($roleName)
	{
        return Defender::roleExists($roleName);
	}

	/**
	 * Check if the permission $permissionName exists in the database.
	 *
	 * @param  string $permissionName
	 *
	 * @return bool
	 */

	public function permissionExists($permissionName)
	{
        return Defender::permissionExists($permissionName);
	}

	/**
	 * Find the role in the database by the name $roleName.
	 *
	 * @param  string $roleName
	 *
	 * @return bool
	 */

	public function findRole($roleName)
	{
        return Defender::findRole($roleName);
	}

	/**
	 * Find the role in the database by the role ID roleId.
	 *
	 * @param  int $roleId
	 *
	 * @return bool
	 */

	public function findRoleById($roleId)
	{
        return Defender::findRoleById($roleId);
	}

	/**
	 * Find the permission in the database by the name $permissionName.
	 *
	 * @param  string $permissionName
	 *
	 * @return bool
	 */

	public function findPermission($permissionName)
	{
        return Defender::findPermission($permissionName);
	}

	/**
	 * Find the permission in the database by the ID $permissionId.
	 *
	 * @param  string $permissionId
	 *
	 * @return bool
	 */

	public function findPermissionById($permissionId)
	{
        return Defender::findPermissionById($permissionId);
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
	 * Returns all permissions avilable .
	 *
	 * @return mixed
	 */
	public function permissions($grouped = false)
	{
		$this->permission->orderBy('readable_name');
		$result =  $this->permission->lists('readable_name', 'name')->toArray();
		if (!$grouped) return $result;

		$array = array();
		foreach ($result as $key => $value) {
		  array_set($array, $key, $value);
		}
		return $array;

	}


}

