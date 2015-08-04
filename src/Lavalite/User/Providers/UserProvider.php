<?php namespace Lavalite\User\Providers;
/**
 * Part of the Lavalite package.
 *
 *
 * @package    Lavalite
 * @version    2.0.0
 */

use Lavalite\User\Model\User;
use Lavalite\Hashing\HasherInterface;
use Lavalite\User\Interfaces\GroupInterface;
use Lavalite\User\Interfaces\GroupProviderInterface;
use Lavalite\User\Interfaces\UserInterface;
use Lavalite\User\Interfaces\UserProviderInterface;
use Lavalite\User\Exceptions\UserNotActivatedException;
use Lavalite\User\Exceptions\UserNotFoundException;
use Lavalite\User\Exceptions\WrongPasswordException;

class UserProvider  extends BaseProvider implements UserProviderInterface {

	/**
	 * The Eloquent user model.
	 *
	 * @var string
	 */
	protected $model = 'Lavalite\User\Models\User';

	/**
	 * The hasher for the model.
	 *
	 * @var \Lavalite\Hashing\HasherInterface
	 */
	protected $hasher;

	/**
	 * Create a new Eloquent User provider.
	 *
	 * @param  \Lavalite\Hashing\HasherInterface  $hasher
	 * @param  string  $model
	 * @return void
	 */
	public function __construct(\Lavalite\User\Models\User $model)
	{

			$this->model = $model;

	}

    public function json()
    {
        return  $this->model->get()->toArray();
    }

	/**
	 * Finds a user by the given user ID.
	 *
	 * @param  mixed  $id
	 * @return \Lavalite\User\Interfaces\UserInterface
	 * @throws \Lavalite\User\Exceptions\UserNotFoundException
	 */
	public function findById($id)
	{

		if ( ! $user = $this->model->newQuery()->find($id))
		{
			throw new UserNotFoundException("A user could not be found with ID [$id].");
		}

		return $user;
	}

	/**
	 * Finds a user by the login value.
	 *
	 * @param  string  $login
	 * @return \Lavalite\User\Interfaces\UserInterface
	 * @throws \Lavalite\User\Exceptions\UserNotFoundException
	 */
	public function findByLogin($login)
	{

		if ( ! $user = $this->model->where($this->model->getLoginName(), '=', $login)->first())
		{
			throw new UserNotFoundException("A user could not be found with a login value of [$login].");
		}

		return $user;
	}

	/**
	 * Finds a user by the given credentials.
	 *
	 * @param  array  $credentials
	 * @return \Lavalite\User\Interfaces\UserInterface
	 * @throws \Lavalite\User\Exceptions\UserNotFoundException
	 */
	public function findByCredentials(array $credentials)
	{
		$loginName = $this->model->getLoginName();

		if ( ! array_key_exists($loginName, $credentials))
		{
			throw new \InvalidArgumentException("Login attribute [$loginName] was not provided.");
		}

		$passwordName = $this->model->getPasswordName();

		$query              = $this->model->newQuery();
		$hashableAttributes = $this->model->getHashableAttributes();
		$hashedCredentials  = array();

		// build query from given credentials
		foreach ($credentials as $credential => $value)
		{
			// Remove hashed attributes to check later as we need to check these
			// values after we retrieved them because of salts
			if (in_array($credential, $hashableAttributes))
			{
				$hashedCredentials = array_merge($hashedCredentials, array($credential => $value));
			}
			else
			{
				$query = $query->where($credential, '=', $value);
			}
		}
		if ( ! $user = $query->first())
		{
print_r((\DB::getQueryLog()));
			throw new UserNotFoundException("A user was not found with the given credentials.");
		}

		// Now check the hashed credentials match ours
		foreach ($hashedCredentials as $credential => $value)
		{
			if ( ! $this->model->checkHash($value, $user->{$credential}))
			{
				$message = "A user was found to match all plain text credentials however hashed credential [$credential] did not match.";

				if ($credential == $passwordName)
				{
					throw new WrongPasswordException($message);
				}

				throw new UserNotFoundException($message);
			}
			else if ($credential == $passwordName)
			{
				if (method_exists($this->model, 'needsRehashed') &&
					$this->model->needsRehashed($user->{$credential}))
				{
					// The algorithm used to create the hash is outdated and insecure.
					// Rehash the password and save.
					$user->{$credential} = $value;
					$user->save();
				}
			}
		}

		return $user;
	}

	/**
	 * Finds a user by the given activation code.
	 *
	 * @param  string  $code
	 * @return \Lavalite\User\Interfaces\UserInterface
	 * @throws \Lavalite\User\Exceptions\UserNotFoundException
	 * @throws InvalidArgumentException
	 * @throws RuntimeException
	 */
	public function findByActivationCode($code)
	{
		if ( ! $code)
		{
			throw new \InvalidArgumentException("No activation code passed.");
		}


		$result = $this->model->newQuery()->where('activation_code', '=', $code)->get();

		if (($count = $result->count()) > 1)
		{
			throw new \RuntimeException("Found [$count] users with the same activation code.");
		}

		if ( ! $user = $result->first())
		{
			throw new UserNotFoundException("A user was not found with the given activation code.");
		}

		return $user;
	}

	/**
	 * Finds a user by the given reset password code.
	 *
	 * @param  string  $code
	 * @return \Lavalite\User\Interfaces\UserInterface
	 * @throws RuntimeException
	 * @throws \Lavalite\User\Exceptions\UserNotFoundException
	 */
	public function findByResetPasswordCode($code)
	{

		$result = $this->model->newQuery()->where('reset_password_code', '=', $code)->get();

		if (($count = $result->count()) > 1)
		{
			throw new \RuntimeException("Found [$count] users with the same reset password code.");
		}

		if ( ! $user = $result->first())
		{
			throw new UserNotFoundException("A user was not found with the given reset password code.");
		}

		return $user;
	}

	/**
	 * Returns an array containing all users.
	 *
	 * @return array
	 */
	public function findAll()
	{
		return $this->model->newQuery()->get()->all();
	}

	/**
	 * Returns all users who belong to
	 * a group.
	 *
	 * @param  \Lavalite\User\Interfaces\GroupInterface  $group
	 * @return array
	 */
	public function findAllInGroup(GroupInterface $group)
	{
		return $group->users()->get();
	}

	/**
	 * Returns all users with access to
	 * a permission(s).
	 *
	 * @param  string|array  $permissions
	 * @return array
	 */
	public function findAllWithAccess($permissions)
	{
		return array_filter($this->findAll(), function($user) use ($permissions)
		{
			return $user->hasAccess($permissions);
		});
	}

	/**
	 * Returns all users with access to
	 * any given permission(s).
	 *
	 * @param  array  $permissions
	 * @return array
	 */
	public function findAllWithAnyAccess(array $permissions)
	{
		return array_filter($this->findAll(), function($user) use ($permissions)
		{
			return $user->hasAnyAccess($permissions);
		});
	}

	/**
	 * Creates a user.
	 *
	 * @param  array  $credentials
	 * @return \Lavalite\User\Interfaces\UserInterface
	 */
	public function create(array $credentials)
	{
		$user = $this->instance($credentials);
		$user->email 	= $credentials['email'];
		$user->password = $credentials['password'];
		$user->fill($credentials);
		$user->save();
		return $user;

	}

	/**
	 * Returns an empty user object.
	 *
	 * @return \Lavalite\User\Interfaces\UserInterface
	 */
	public function getEmptyUser()
	{
		return $this->instance();
	}



	/**
	 * Sets a new model class name to be used at
	 * runtime.
	 *
	 * @param  string  $model
	 */
	public function setModel($model)
	{
		$this->model = $model;
		$this->setupHasherWithModel();
	}

	/**
	 * Statically sets the hasher with the model.
	 *
	 * @return void
	 */
	public function setupHasherWithModel()
	{
		if (method_exists($this->model, 'setHasher'))
		{
			forward_static_call_array(array($this->model, 'setHasher'), array($model));
		}
	}

}
