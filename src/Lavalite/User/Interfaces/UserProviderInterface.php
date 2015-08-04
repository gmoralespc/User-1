<?php namespace Lavalite\User\Interfaces;
/**
 * Part of the Lavalite package.
 *
 *
 * @package    Lavalite
 * @version    2.0.0
 */

use Lavalite\User\Interfaces\GroupInterface;

interface UserProviderInterface {

	/**
	 * Finds a user by the given user ID.
	 *
	 * @param  mixed  $id
	 * @return \Lavalite\User\Interfaces\UserInterface
	 * @throws \Lavalite\User\Exceptions\UserNotFoundException
	 */
	public function findById($id);

	/**
	 * Finds a user by the login value.
	 *
	 * @param  string  $login
	 * @return \Lavalite\User\Interfaces\UserInterface
	 * @throws \Lavalite\User\Exceptions\UserNotFoundException
	 */
	public function findByLogin($login);

	/**
	 * Finds a user by the given credentials.
	 *
	 * @param  array  $credentials
	 * @return \Lavalite\User\Interfaces\UserInterface
	 * @throws \Lavalite\User\Exceptions\UserNotFoundException
	 */
	public function findByCredentials(array $credentials);

	/**
	 * Finds a user by the given activation code.
	 *
	 * @param  string  $code
	 * @return \Lavalite\User\Interfaces\UserInterface
	 * @throws \Lavalite\User\Exceptions\UserNotFoundException
	 * @throws InvalidArgumentException
	 * @throws RuntimeException
	 */
	public function findByActivationCode($code);

	/**
	 * Finds a user by the given reset password code.
	 *
	 * @param  string  $code
	 * @return \Lavalite\User\Interfaces\UserInterface
	 * @throws RuntimeException
	 * @throws \Lavalite\User\Exceptions\UserNotFoundException
	 */
	public function findByResetPasswordCode($code);

	/**
	 * Returns an all users.
	 *
	 * @return array
	 */
	public function findAll();

	/**
	 * Returns all users who belong to
	 * a group.
	 *
	 * @param  \Lavalite\User\Interfaces\GroupInterface  $group
	 * @return array
	 */
	public function findAllInGroup(GroupInterface $group);

	/**
	 * Returns all users with access to
	 * a permission(s).
	 *
	 * @param  string|array  $permissions
	 * @return array
	 */
	public function findAllWithAccess($permissions);

	/**
	 * Returns all users with access to
	 * any given permission(s).
	 *
	 * @param  array  $permissions
	 * @return array
	 */
	public function findAllWithAnyAccess(array $permissions);

	/**
	 * Creates a user.
	 *
	 * @param  array  $credentials
	 * @return \Lavalite\User\Interfaces\UserInterface
	 */
	public function create(array $credentials);

	/**
	 * Returns an empty user object.
	 *
	 * @return \Lavalite\User\Interfaces\UserInterface
	 */
	public function getEmptyUser();

}
