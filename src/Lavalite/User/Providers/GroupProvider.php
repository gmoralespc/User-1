<?php namespace Lavalite\User\Providers;
/**
 * Part of the Lavalite package.
 *
 *
 * @package    Lavalite
 * @version    2.0.0
 */

use Lavalite\User\Interfaces\GroupProviderInterface;
use Lavalite\User\Exceptions\GroupNotFoundException;
use Lavalite\User\Interfaces\GroupsProviderInterface;

class GroupProvider extends BaseProvider implements GroupProviderInterface {

	/**
	 * The Eloquent group model.
	 *
	 * @var string
	 */
	protected $model = '';

	/**
	 * Create a new Eloquent Group provider.
	 *
	 * @param  string  $model
	 * @return void
	 */
	public function __construct(\Lavalite\User\Models\Group $model)
	{

			$this->model = $model;
	}

	/**
	 * Find the group by ID.
	 *
	 * @param  int  $id
	 * @return \Lavalite\User\Interfaces\GroupInterface  $group
	 * @throws \Lavalite\User\Exceptions\GroupNotFoundException
	 */
	public function findById($id)
	{

		if ( ! $group = $this->find($id))
		{
			throw new GroupNotFoundException("A group could not be found with ID [$id].");
		}

		return $group;
	}

	/**
	 * Find the group by name.
	 *
	 * @param  string  $name
	 * @return \Lavalite\User\Interfaces\GroupInterface  $group
	 * @throws \Lavalite\User\Exceptions\GroupNotFoundException
	 */
	public function findByName($name)
	{

		if ( ! $group = $this->model->newQuery()->where('name', '=', $name)->first())
		{
			throw new GroupNotFoundException("A group could not be found with the name [$name].");
		}

		return $group;
	}

	/**
	 * Returns all groups.
	 *
	 * @return array  $groups
	 */
	public function findAll()
	{

		return $this->model->newQuery()->get()->all();
	}

	/**
	 * Creates a group.
	 *
	 * @param  array  $attributes
	 * @return \Lavalite\User\Interfaces\GroupInterface
	 */
	public function create(array $attributes)
	{
		$group = $this->instance();
		$group->fill($attributes);
		$group->save();
		return $group;
	}


}
