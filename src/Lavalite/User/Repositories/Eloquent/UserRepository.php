<?php namespace Lavalite\User\Repositories\Eloquent;

use Lavalite\User\Interfaces\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return "Lavalite\\User\\Models\\User";
    }

    /**
     * Retrive users list based on role
     *
     * @param string $role
     * @param array $columns
     * @return mixed
     */
    public function json($role = NULL, $columns = array('*'))
    {
        $results = $this->model->with(['roles' => function($query) use ($role){
            if (is_null($role))
                return $query;

            return $query->where('roles.name', '=', $role);

        }])->get($columns)->toArray();

        $this->resetModel();
        foreach ($results as $key => $val)
            $results[$key] = array_dot($val);
        return $results;
    }

}
