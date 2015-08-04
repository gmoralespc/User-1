<?php namespace Lavalite\User\Interfaces;
use Lavalite\User\Interfaces\UserInterface;

/**
 * Part of the Lavalite package.
 *
 *
 * @package    Lavalite
 * @version    2.0.0
 */

interface ThrottlingProviderInterface {


	/**
	 * Finds a throttler by the given user ID.
	 *
	 * @param  \Lavalite\User\Interfaces\UserInterface   $user
	 * @param  string  $ipAddress
	 * @return \Lavalite\User\Interfaces\ThrottlingInterface
	 */
	public function findByUser(UserInterface $user, $ipAddress = null);

	/**
	 * Finds a throttler by the given user ID.
	 *
	 * @param  mixed   $id
	 * @param  string  $ipAddress
	 * @return \Lavalite\User\Interfaces\ThrottlingInterface
	 */
	public function findByUserId($id, $ipAddress = null);

	/**
	 * Finds a throttling interface by the given user login.
	 *
	 * @param  string  $login
	 * @param  string  $ipAddress
	 * @return \Lavalite\User\Interfaces\ThrottlingInterface
	 */
	public function findByUserLogin($login, $ipAddress = null);

	/**
	 * Enable throttling.
	 *
	 * @return void
	 */
	public function enable();

	/**
	 * Disable throttling.
	 *
	 * @return void
	 */
	public function disable();

	/**
	 * Check if throttling is enabled.
	 *
	 * @return bool
	 */
	public function isEnabled();

}
