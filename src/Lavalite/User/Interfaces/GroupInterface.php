<?php namespace Lavalite\User\Interfaces;
/**
 * Part of the Lavalite package.
 *
 *
 * @package    Lavalite
 * @version    2.0.0
 */

interface GroupInterface {

	/**
	 * Returns the group's ID.
	 *
	 * @return mixed
	 */
	public function getId();

	/**
	 * Returns the group's name.
	 *
	 * @return string
	 */
	public function getName();

	/**
	 * Returns permissions for the group.
	 *
	 * @return array
	 */
	public function getPermissions();

	/**
	 * Saves the group.
	 *
	 * @return bool
	 */
	public function save();

	/**
	 * Delete the group.
	 *
	 * @return bool
	 */
	public function delete();

}
