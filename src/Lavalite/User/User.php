<?php namespace Lavalite\User;
/**
 * Part of the Lavalite package.
 *
 *
 * @package    Lavalite
 * @version    2.0.0
 */
use Theme;
use Lavalite\User\Interfaces\GroupInterface;
use Lavalite\User\Interfaces\GroupProviderInterface;

use Lavalite\User\Interfaces\UserInterface;
use Lavalite\User\Interfaces\UserProviderInterface;

use Lavalite\User\Interfaces\ThrottlingInterface;
use Lavalite\User\Interfaces\ThrottlingProviderInterface;

use Lavalite\User\Interfaces\SessionInterface;
use Lavalite\User\Interfaces\CookieInterface;

use Lavalite\User\Exceptions\LoginRequiredException;
use Lavalite\User\Exceptions\PasswordRequiredException;
use Lavalite\User\Exceptions\UserNotFoundException;
use Lavalite\User\Exceptions\UserNotActivatedException;

class User {

	/**
	 * The user that's been retrieved and is used
	 * for authentication. Authentication methods
	 * are available for finding the user to set
	 * here.
	 *
	 * @var \Lavalite\User\Interfaces\UserInterface
	 */
	protected $user;

	/**
	 * The session driver used by Lavalite.
	 *
	 * @var \Lavalite\Sessions\SessionInterface
	 */
	protected $session;

	/**
	 * The cookie driver used by Lavalite.
	 *
	 * @var \Lavalite\Cookies\CookieInterface
	 */
	protected $cookie;

	/**
	 * The user provider, used for retrieving
	 * objects which implement the Lavalite user
	 * interface.
	 *
	 * @var \Lavalite\User\Interfaces\GroupProviderInterface
	 */
	protected $userProvider;

	/**
	 * The group provider, used for retrieving
	 * objects which implement the Lavalite group
	 * interface.
	 *
	 * @var \Lavalite\User\Interfaces\GroupsProviderInterface
	 */
	protected $groupProvider;

	/**
	 * The throttle provider, used for retrieving
	 * objects which implement the Lavalite throttling
	 * interface.
	 *
	 * @var \Lavalite\User\Interfaces\ThrottlingProviderInterface
	 */
	protected $throttleProvider;

	/**
	 * The client's IP address associated with Lavalite.
	 *
	 * @var string
	 */
	protected $ipAddress = '0.0.0.0';

	/**
	 * Create a new Lavalite object.
	 *
	 * @param  \Lavalite\User\Interfaces\GroupProviderInterface $userProvider
	 * @param  \Lavalite\User\Interfaces\GroupsProviderInterface $groupProvider
	 * @param  \Lavalite\User\Interfaces\ThrottlingProviderInterface $throttleProvider
	 * @param  \Lavalite\Sessions\SessionInterface $session
	 * @param  \Lavalite\Cookies\CookieInterface $cookie
	 * @param  string $ipAddress
	 * @return void
	 */
	public function __construct(
		UserProviderInterface $userProvider,
		GroupProviderInterface $groupProvider,
		ThrottlingProviderInterface $throttleProvider,

		SessionInterface $session,
		CookieInterface $cookie,

		$ipAddress = null
	)
	{
		$this->userProvider     = $userProvider ?: new UserProvider();
		$this->groupProvider    = $groupProvider ?: new GroupProvider;
		$this->throttleProvider = $throttleProvider ?: new ThrottleProvider($this->userProvider);

		$this->session          = $session ?: new Session;
		$this->cookie           = $cookie ?: new NativeCookie;

		if (isset($ipAddress))
		{
			$this->ipAddress = $ipAddress;
		}
	}

	/**
	 * Registers a user by giving the required credentials
	 * and an optional flag for whether to activate the user.
	 *
	 * @param  array  $credentials
	 * @param  bool   $activate
	 * @return \Lavalite\User\Interfaces\UserInterface
	 */
	public function register(array $credentials, $activate = false)
	{
		$user = $this->userProvider->create($credentials);

		if ($activate)
		{
			$user->attemptActivation($user->getActivationCode());
		}

		return $this->user = $user;
	}


	/**
	 * Attempts to authenticate the given user
	 * according to the passed credentials.
	 *
	 * @param  array  $credentials
	 * @param  bool   $remember
	 * @return \Lavalite\User\Interfaces\UserInterface
	 * @throws \Lavalite\Throttling\UserBannedException
	 * @throws \Lavalite\Throttling\UserSuspendedException
	 * @throws \Lavalite\User\Exceptions\LoginRequiredException
	 * @throws \Lavalite\User\Exceptions\PasswordRequiredException
	 * @throws \Lavalite\User\Exceptions\UserNotFoundException
	 */
	public function authenticate(array $credentials, $remember = false)
	{
		// We'll default to the login name field, but fallback to a hard-coded
		// 'login' key in the array that was passed.
		$loginName = $this->userProvider->getEmptyUser()->getLoginName();
		$loginCredentialKey = (isset($credentials[$loginName])) ? $loginName : 'login';

		if (empty($credentials[$loginCredentialKey]))
		{
			throw new LoginRequiredException("The [$loginCredentialKey] attribute is required.");
		}

		if (empty($credentials['password']))
		{
			throw new PasswordRequiredException('The password attribute is required.');
		}

		// If the user did the fallback 'login' key for the login code which
		// did not match the actual login name, we'll adjust the array so the
		// actual login name is provided.
		if ($loginCredentialKey !== $loginName)
		{
			$credentials[$loginName] = $credentials[$loginCredentialKey];
			unset($credentials[$loginCredentialKey]);
		}

		// If throttling is enabled, we'll firstly check the throttle.
		// This will tell us if the user is banned before we even attempt
		// to authenticate them
		if ($throttlingEnabled = $this->throttleProvider->isEnabled())
		{
			if ($throttle = $this->throttleProvider->findByUserLogin($credentials[$loginName], $this->ipAddress))
			{
				$throttle->check();
			}
		}

		try
		{
			$user = $this->userProvider->findByCredentials($credentials);
		}
		catch (UserNotFoundException $e)
		{
			if ($throttlingEnabled and isset($throttle))
			{
				$throttle->addLoginAttempt();
			}

			throw $e;
		}

		if ($throttlingEnabled and isset($throttle))
		{
			$throttle->clearLoginAttempts();
		}

		$user->clearResetPassword();

		$this->login($user, $remember);

		return $this->user;
	}

	/**
	 * Alias for authenticating with the remember flag checked.
	 *
	 * @param  array  $credentials
	 * @return \Lavalite\User\Interfaces\UserInterface
	 */
	public function authenticateAndRemember(array $credentials)
	{
		return $this->authenticate($credentials, true);
	}

	/**
	 * Check to see if the user is logged in and activated, and hasn't been banned or suspended.
	 *
	 * @return bool
	 */
	public function check()
	{
		if (is_null($this->user))
		{
			// Check session first, follow by cookie
			if ( ! $userArray = $this->session->get() and ! $userArray = $this->cookie->get())
			{
				return false;
			}

			// Now check our user is an array with two elements,
			// the username followed by the persist code
			if ( ! is_array($userArray) or count($userArray) !== 2)
			{
				return false;
			}

			list($id, $persistCode) = $userArray;

			// Let's find our user
			try
			{
				$user = $this->getUserProvider()->findById($id);
			}
			catch (UserNotFoundException $e)
			{
				return false;
			}

			// Great! Let's check the session's persist code
			// against the user. If it fails, somebody has tampered
			// with the cookie / session data and we're not allowing
			// a login
			if ( ! $user->checkPersistCode($persistCode))
			{
				return false;
			}

			// Now we'll set the user property on Lavalite
			$this->user = $user;
		}

		// Let's check our cached user is indeed activated
		if ( ! $user = $this->getUser() or ! $user->isActivated())
		{
			return false;
		}
		// If throttling is enabled we check it's status
		if( $this->getThrottleProvider()->isEnabled())
		{
			// Check the throttle status
			$throttle = $this->getThrottleProvider()->findByUser( $user );

			if( $throttle->isBanned() or $throttle->isSuspended())
			{
				$this->logout();
				return false;
			}
		}

		return true;
	}

	/**
	 * Logs in the given user and sets properties
	 * in the session.
	 *
	 * @param  \Lavalite\User\Interfaces\UserInterface  $user
	 * @param  bool  $remember
	 * @return void
	 * @throws \Lavalite\User\Exceptions\UserNotActivatedException
	 */
	public function login(UserInterface $user, $remember = false)
	{
		if ( ! $user->isActivated())
		{
			$login = $user->getLogin();
			throw new UserNotActivatedException("Cannot login user [$login] as they are not activated.");
		}

		$this->user = $user;

		// Create an array of data to persist to the session and / or cookie
		$toPersist = array($user->getId(), $user->getPersistCode());

		// Set sessions
		$this->session->put($toPersist);

		if ($remember)
		{
			$this->cookie->forever($toPersist);
		}

		// The user model can attach any handlers
		// to the "recordLogin" event.
		$user->recordLogin();
	}

	/**
	 * Alias for logging in and remembering.
	 *
	 * @param  \Lavalite\User\Interfaces\UserInterface  $user
	 */
	public function loginAndRemember(UserInterface $user)
	{
		$this->login($user, true);
	}

	/**
	 * Logs the current user out.
	 *
	 * @return void
	 */
	public function logout()
	{
		$this->user = null;

		$this->session->forget();
		$this->cookie->forget();
	}

	/**
	 * Sets the user to be used by Lavalite.
	 *
	 * @param  \Lavalite\User\Interfaces\UserInterface
	 * @return void
	 */
	public function setUser(UserInterface $user)
	{
		$this->user = $user;
	}

	/**
	 * Returns the current user being used by Lavalite, if any.
	 *
	 * @return \Lavalite\User\Interfaces\UserInterface
	 */
	public function getUser()
	{
		// We will lazily attempt to load our user
		if (is_null($this->user))
		{
			$this->check();
		}

		return $this->user;
	}

	/**
	 * Sets the session driver for Lavalite.
	 *
	 * @param  \Lavalite\Sessions\SessionInterface  $session
	 * @return void
	 */
	public function setSession(SessionInterface $session)
	{
		$this->session = $session;
	}

	/**
	 * Gets the session driver for Lavalite.
	 *
	 * @return \Lavalite\Sessions\SessionInterface
	 */
	public function getSession()
	{
		return $this->session;
	}

	/**
	 * Sets the cookie driver for Lavalite.
	 *
	 * @param  \Lavalite\Cookies\CookieInterface  $cookie
	 * @return void
	 */
	public function setCookie(CookieInterface $cookie)
	{
		$this->cookie = $cookie;
	}

	/**
	 * Gets the cookie driver for Lavalite.
	 *
	 * @return \Lavalite\Cookies\CookieInterface
	 */
	public function getCookie()
	{
		return $this->cookie;
	}

	/**
	 * Sets the group provider for Lavalite.
	 *
	 * @param  \Lavalite\User\Interfaces\GroupsProviderInterface
	 * @return void
	 */
	public function setGroupProvider(GroupProviderInterface $groupProvider)
	{
		$this->groupProvider = $groupProvider;
	}

	/**
	 * Gets the group provider for Lavalite.
	 *
	 * @return \Lavalite\User\Interfaces\GroupsProviderInterface
	 */
	public function getGroupProvider()
	{
		return $this->groupProvider;
	}

	/**
	 * Sets the user provider for Lavalite.
	 *
	 * @param  \Lavalite\User\Interfaces\GroupProviderInterface
	 * @return void
	 */
	public function setUserProvider(UserProviderInterface $userProvider)
	{
		$this->userProvider = $userProvider;
	}

	/**
	 * Gets the user provider for Lavalite.
	 *
	 * @return \Lavalite\User\Interfaces\GroupProviderInterface
	 */
	public function getUserProvider()
	{
		return $this->userProvider;
	}

	/**
	 * Sets the throttle provider for Lavalite.
	 *
	 * @param  \Lavalite\User\Interfaces\ThrottlingProviderInterface
	 * @return void
	 */
	public function setThrottleProvider(ThrottlingProviderInterface $throttleProvider)
	{
		$this->throttleProvider = $throttleProvider;
	}

	/**
	 * Gets the throttle provider for Lavalite.
	 *
	 * @return \Lavalite\User\Interfaces\ThrottlingProviderInterface
	 */
	public function getThrottleProvider()
	{
		return $this->throttleProvider;
	}

	/**
	 * Sets the IP address Lavalite is bound to.
	 *
	 * @param  string  $ipAddress
	 * @return void
	 */
	public function setIpAddress($ipAddress)
	{
		$this->ipAddress = $ipAddress;
	}

	/**
	 * Gets the IP address Lavalite is bound to.
	 *
	 * @return string
	 */
	public function getIpAddress()
	{
		return $this->ipAddress;
	}

	/**
	 * Find the group by ID.
	 *
	 * @param  int  $id
	 * @return \Lavalite\User\Interfaces\GroupInterface  $group
	 * @throws \Lavalite\User\Exceptions\GroupNotFoundException
	 */
	public function findGroupById($id)
	{
		return $this->groupProvider->findById($id);
	}

	/**
	 * Find the group by name.
	 *
	 * @param  string  $name
	 * @return \Lavalite\User\Interfaces\GroupInterface  $group
	 * @throws \Lavalite\User\Exceptions\GroupNotFoundException
	 */
	public function findGroupByName($name)
	{
		return $this->groupProvider->findByName($name);
	}

	/**
	 * Returns all groups.
	 *
	 * @return array  $groups
	 */
	public function findAllGroups()
	{
		return $this->groupProvider->findAll();
	}

	/**
	 * Creates a group.
	 *
	 * @param  array  $attributes
	 * @return \Lavalite\User\Interfaces\GroupInterface
	 */
	public function createGroup(array $attributes)
	{
		return $this->groupProvider->create($attributes);
	}


	/**
	 * Finds a user by the given user ID.
	 *
	 * @param  mixed  $id
	 * @return \Lavalite\User\Interfaces\UserInterface
	 * @throws \Lavalite\User\Exceptions\UserNotFoundException
	 */
	public function findUserById($id)
	{
		return $this->userProvider->findById($id);
	}

	/**
	 * Finds a user by the login value.
	 *
	 * @param  string  $login
	 * @return \Lavalite\User\Interfaces\UserInterface
	 * @throws \Lavalite\User\Exceptions\UserNotFoundException
	 */
	public function findUserByLogin($login)
	{
		return $this->userProvider->findByLogin($login);
	}

	/**
	 * Finds a user by the given credentials.
	 *
	 * @param  array  $credentials
	 * @return \Lavalite\User\Interfaces\UserInterface
	 * @throws \Lavalite\User\Exceptions\UserNotFoundException
	 */
	public function findUserByCredentials(array $credentials){
		return $this->userProvider->findByCredentials($credentials);
	}

	/**
	 * Finds a user by the given activation code.
	 *
	 * @param  string  $code
	 * @return \Lavalite\User\Interfaces\UserInterface
	 * @throws \RuntimeException
	 * @throws \Lavalite\User\Exceptions\UserNotFoundException
	 */
	public function findUserByActivationCode($code)
	{
		return $this->userProvider->findByActivationCode($code);
	}

	/**
	 * Finds a user by the given reset password code.
	 *
	 * @param  string  $code
	 * @return \Lavalite\User\Interfaces\UserInterface
	 * @throws \RuntimeException
	 * @throws \Lavalite\User\Exceptions\UserNotFoundException
	 */
	public function findUserByResetPasswordCode($code)
	{
		return $this->userProvider->findByResetPasswordCode($code);
	}

	/**
	 * Returns an all users.
	 *
	 * @return array
	 */
	public function findAllUsers()
	{
		return $this->userProvider->findAll();
	}

	/**
	 * Returns all users who belong to
	 * a group.
	 *
	 * @param  \Lavalite\User\Interfaces\GroupInterface  $group
	 * @return array
	 */
	public function findAllUsersInGroup($group)
	{
		return $this->userProvider->findAllInGroup($group);
	}

	/**
	 * Returns all users with access to
	 * a permission(s).
	 *
	 * @param  string|array  $permissions
	 * @return array
	 */
	public function findAllUsersWithAccess($permissions)
	{
		return $this->userProvider->findAllWithAccess($permissions);
	}

	/**
	 * Returns all users with access to
	 * any given permission(s).
	 *
	 * @param  array  $permissions
	 * @return array
	 */
	public function findAllUsersWithAnyAccess(array $permissions)
	{
		return $this->userProvider->findAllWithAnyAccess($permissions);
	}

	/**
	 * Creates a user.
	 *
	 * @param  array  $credentials
	 * @return \Lavalite\User\Interfaces\UserInterface
	 */
	public function createUser(array $credentials)
	{
		return $this->userProvider->create($credentials);
	}

	/**
	 * Returns an empty user object.
	 *
	 * @return \Lavalite\User\Interfaces\UserInterface
	 */
	public function getEmptyUser()
	{
		return $this->userProvider->getEmptyUser();
	}

	/**
	 * Finds a throttler by the given user ID.
	 *
	 * @param  mixed   $id
	 * @param  string  $ipAddress
	 * @return \Lavalite\User\Interfaces\ThrottlingInterface
	 */
	public function findThrottlerByUserId($id, $ipAddress = null)
	{
		return $this->throttleProvider->findByUserId($id,$ipAddress);
	}

	/**
	 * Finds a throttling interface by the given user login.
	 *
	 * @param  string  $login
	 * @param  string  $ipAddress
	 * @return \Lavalite\User\Interfaces\ThrottlingInterface
	 */
	public function findThrottlerByUserLogin($login, $ipAddress = null)
	{
		return $this->throttleProvider->findByUserLogin($login,$ipAddress);
	}

	public function name(){
		return User::getUser()->first_name . ' ' . User::getUser()->last_name;;
	}

    public function avatar($width = null, $height = null)
    {
    	if (!empty(User::getUser()->photo)) return User::getUser()->photo;
        if (User::getUser()->sex == 'male') {
            return Theme::asset()->url('img/avatar5.png');
        } else {
            return Theme::asset()->url('img/avatar3.png');
        }
    }

	public function designation(){
		return User::getuser()->designation;
	}

	public function joined(){
		return date(' M, Y', strtotime(User::getUser()->created_at));
	}

	public function id(){
		return User::getuser()->id;
	}

	public function type(){
		return User::getuser()->type;
	}
	/**
	 * Handle dynamic method calls into the method.
	 *
	 * @param  string  $method
	 * @param  array   $parameters
	 * @return mixed
	 * @throws \BadMethodCallException
	 */
	public function __call($method, $parameters)
	{
		if (isset($this->user))
		{
			return call_user_func_array(array($this->user, $method), $parameters);
		}

		throw new \BadMethodCallException("Method [$method] is not supported by Lavalite or no User has been set on Lavalite to access shortcut method.");
	}


}

