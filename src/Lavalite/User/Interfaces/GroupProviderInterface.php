<?php namespace Lavalite\User\Interfaces;
/**
 * Part of the Lavalite package.
 *
 *
 * @package    Lavalite
 * @version    2.0.0
 */

interface GroupProviderInterface {

	/**
	 * Find the group by ID.
	 *
	 * @param  int  $id
	 * @return \Lavalite\User\Interfaces\GroupInterface  $group
	 * @throws \Lavalite\User\Exceptions\GroupNotFoundException
	 */
	public function findById($id);

	/**
	 * Find the group by name.
	 *
	 * @param  string  $name
	 * @return \Lavalite\User\Interfaces\GroupInterface  $group
	 * @throws \Lavalite\User\Exceptions\GroupNotFoundException
	 */
	public function findByName($name);

	/**
	 * Returns all groups.
	 *
	 * @return array  $groups
	 */
	public function findAll();

	/**
	 * Creates a group.
	 *
	 * @param  array  $attributes
	 * @return \Lavalite\User\Interfaces\GroupInterface
	 */
	public function create(array $attributes);

}
