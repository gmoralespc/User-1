<?php namespace Lavalite\User\Controllers;

use App;
use Lang;
use View;
use Input;
use Event;
use Sentry;
use Config;
use Former;
use Session;
use Redirect;
use Validator;

class GroupAdminController extends \AdminController {

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->beforeFilter('admin_auth');

        parent::__construct();
    }



    protected function hasAccess()
    {
        if(!Sentry::getUser()->hasAnyAccess(array('user')))
            App::abort(401, Lang::get('messages.error.auth'));

        return true;
    }

    protected function permissions()
    {
        $p              = array();

        $permissions    = Config::get('user::user.permissions.admin');

        foreach ($permissions as $key => $value) {
            $p[$value]  = Sentry::getUser()->hasAccess('user.'.$value);
        }

        return $p;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index()
    {
        $this->hasAccess();
        $data['permissions']           = $this->permissions();
        $data['q']                     = '';
        // Index - show the user's group details.
        try
        {
            // Find the current user
            if ( ! Sentry::check())
            {
                // User is not logged in, or is not activated
                Session::flash('error', 'You must be logged in to perform that action.');
                return Redirect::to('/');
            }
            else
            {
                // User is logged in
                $user = Sentry::getUser();

                // Get the user groups
                $data['myGroups'] = $user->getGroups();

                //Get all the available groups.
                $data['groups'] = Sentry::getGroupProvider()->findAll();

                //Get user rights of each module
                $data['rights'] = $this->userRights();
                return $this->theme->of('user::group.admin.index', $data)->render(); //View::make('', $data);
            }

        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            Session::flash('error', 'User was not found.');
            return Redirect::to('admin/user/group/index');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //Form for creating a new Group
        $data['rights'] = $this->userRights();
        return $this->theme->of('user::group.admin.create', $data)->render(); //View::make('user::group.admin.create');
    }



    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //Store the new group in the db.
        //Start with Data Validation
        // Gather Sanitized Input
        $input = array(
            'name' => Input::get('name')
            );

        // Set Validation Rules
        $rules = array (
            'name' => 'required|min:4'
            );

        //Run input validation
        $v = Validator::make($input, $rules);

        if ($v->fails())
        {
            // Validation has failed
            return Redirect::to('admin/user/group/create')->withErrors($v)->withInput();
        }
        else
        {
            try
            {
                // Create the group
                $group = Sentry::getGroupProvider()->create(array(

                    'name'        => $input['name'],
                    'permissions' => Input::get('permissions')
                    ));

                if ($group) {
                    Session::flash('success', 'New Group Created');
                    return Redirect::to('admin/user/group');
                } else {
                    Session::flash('error', 'New Group was not created');
                    return Redirect::to('admin/user/group');
                }

            }
            catch (Cartalyst\Sentry\Groups\NameRequiredException $e)
            {
                Session::flash('error', 'Name field is required');
                return Redirect::to('admin/user/group/create')->withErrors($v)->withInput();
            }
            catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
            {
                Session::flash('error', 'Group already exists');
                return Redirect::to('admin/user/group/create')->withErrors($v)->withInput();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function show($id)
    {
        //Show a group and its permissions.
        try
        {
            // Find the group using the group id
            $data['group'] = Sentry::getGroupProvider()->findById($id);

            // Get the group permissions
            $data['groupPermissions'] = $data['group']->getPermissions();
        }
        catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
        {
            Session::flash('error', 'Group does not exist.');
            return Redirect::to('admin/user/group');
        }

        return $this->theme->of('user::group.admin.show', $data)->render();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit($id)
    {
        //Pull the selected group
        try
        {
            // Find the group using the group id
            $data['group']          = Sentry::getGroupProvider()->findById($id);
            $data['permissions']    = $data['group']->getPermissions();
            $data['rights']         = $this->userRights();
    print_r($data['permissions']);

        }
        catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
        {
            Session::flash('error', 'Group does not exist.');
            return Redirect::to('admin/user/group');
        }
        return $this->theme->of('user::group.admin.edit', $data)->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update($id)
    {
        // Update the Group.
        // Start with Data Validation
        // Gather Sanitized Input

        $input = array(
            'name' => Input::get('name')
            );

        // Set Validation Rules
        $rules = array (
            'name' => 'required|min:4'
            );

        //Run input validation
        $v = Validator::make($input, $rules);

        if ($v->fails())
        {
            // Validation has failed
            return Redirect::to('admin/user/group/'. $id . '/edit')->withErrors($v)->withInput();
        }
        else
        {

            try
            {
                // Find the group using the group id
                $group = Sentry::getGroupProvider()->findById($id);

                // Update the group details
                $group->name = $input['name'];
                $group->permissions = Input::get('permissions');

                // Update the group
                if ($group->save())
                {
                    // Group information was updated
                    Session::flash('success', 'Group has been updated.');
                    return Redirect::to('admin/user/group');
                }
                else
                {
                    // Group information was not updated
                    Session::flash('error', 'There was a problem updating the group.');
                    return Redirect::to('admin/user/group/'. $id . '/edit')->withErrors($v)->withInput();
                }
            }
            catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
            {
                Session::flash('error', 'Group already exists.');
                return Redirect::to('admin/user/group/'. $id . '/edit')->withErrors($v)->withInput();
            }
            catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
            {
                Session::flash('error', 'Group was not found.');
                return Redirect::to('admin/user/group/'. $id . '/edit')->withErrors($v)->withInput();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy($id)
    {

        try
        {
            // Find the group using the group id
            $group = Sentry::getGroupProvider()->findById($id);

            // Delete the group
            if ($group->delete())
            {
                // Group was successfully deleted
                Session::flash('success', 'Group has been deleted.');
                return Redirect::to('admin/user/group');
            }
            else
            {
                // There was a problem deleting the group
                Session::flash('error', 'There was a problem deleting that group.');
                return Redirect::to('admin/user/group');
            }
        }
        catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
        {
            Session::flash('error', 'Group was not found.');
            return Redirect::to('admin/user/group');
        }
    }

    public function userRights(){

        $packages               = Config::get('lavalite.packages');
        $rights['default']      = Config::get('lavalite.usertypes');

        foreach ($packages as $package => $status){
            $modules    = Config::get("{$package}::modules");
            if (is_array($modules))
            foreach ($modules as $module){
                $rights[$package][$module]   = Config::get("{$package}::{$module}.permissions");
            }
        }

        //dd(print_r($rights));
        return  $rights;
    }

}