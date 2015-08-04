<?php namespace Lavalite\User\Interfaces;
/**
 * Part of the Lavalite package.
 *
 *
 * @package    Lavalite
 * @version    2.0.0
 */

interface ThrottlingInterface {

	/**
	 * Returns the associated user with the throttler.
	 *
	 * @return \Lavalite\User\Interfaces\UserInterface
	 */
	public function getUser();

	/**
	 * Get the current amount of attempts.
	 *
	 * @return int
	 */
	public function getLoginAttempts();

	/**
	 * Add a new login attempt.
	 *
	 * @return void
	 */
	public function addLoginAttempt();

	/**
	 * Clear all login attempts
	 *
	 * @return void
	 */
	public function clearLoginAttempts();

	/**
	 * Suspend the user associated with the throttle
	 *
	 * @return void
	 */
	public function suspend();

	/**
	 * Unsuspend the user.
	 *
	 * @return void
	 */
	public function unsuspend();

	/**
	 * Check if the user is suspended.
	 *
	 * @return bool
	 */
	public function isSuspended();

	/**
	 * Ban the user.
	 *
	 * @return bool
	 */
	public function ban();

	/**
	 * Unban the user.
	 *
	 * @return void
	 */
	public function unban();

	/**
	 * Check if user is banned
	 *
	 * @return void
	 */
	public function isBanned();

	/**
	 * Check user throttle status.
	 *
	 * @return bool
	 * @throws \Lavalite\Throttling\UserBannedException
	 * @throws \Lavalite\Throttling\UserSuspendedException
	 */
	public function check();

	/**
	 * Saves the throttle.
	 *
	 * @return bool
	 */
	public function save();

}