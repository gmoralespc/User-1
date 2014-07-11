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
use Lavalite\User\Interfaces\UserInterface;
use Lavalite\User\Interfaces\GroupInterface;
use Lavalite\User\Interfaces\SessionInterface;


class UserAdminController extends \AdminController
{
    protected $user;
    protected $group;
    protected $session;


    public function __construct(
        UserInterface $user,
        GroupInterface $group,
        SessionInterface $session)
    {
        $this->user = $user;
        $this->group = $group;
        $this->session = $session;

        parent::__construct();

        //Check CSRF token on POST
        $this->beforeFilter('csrf', array('on' => 'post'));

        // Set up Auth Filters
        $this->beforeFilter('auth', array('only' => array('change')));
        $this->beforeFilter('inGroup:Admin', array('only' => array('show', 'index', 'destroy', 'suspend', 'unsuspend', 'ban', 'unban', 'edit', 'update')));
        //array('except' => array('create', 'store', 'activate', 'resend', 'forgot', 'reset')));
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
    public function index($perPage = 15)
    {
        $this->hasAccess();
        $data['permissions']           = $this->permissions();
        $data['q']                     = '';
        $data['users']                 = $this->user->paginate($perPage);

        $data['userStatus'] = array();

        foreach ($data['users'] as $user) {
            if ($user->isActivated())
            {
                $data['userStatus'][$user->id] = "Active";
            }
            else
            {
                $data['userStatus'][$user->id] = "Not Active";
            }

                        //Pull Suspension & Ban info for this user
            $throttle = Sentry::getThrottleProvider()->findByUserId($user->id);

                        //Check for suspension
            if($throttle->isSuspended())
            {
                            // User is Suspended
                $data['userStatus'][$user->id] = "Suspended";
            }

                        //Check for ban
            if($throttle->isBanned())
            {
                            // User is Banned
                $data['userStatus'][$user->id] = "Banned";
            }

        }

        return $this->theme->of('user::user.admin.index',$data)->render();
    }

    /**
     * Show the form for creating a new user.
     *
     * @return Response
     */
    public function create()
    {
        return $this->theme->of('user::user.admin.create')->render();
    }

    /**
     * Store a newly created user.
     *
     * @return Response
     */
    public function store()
    {

        $input = Input::all();

        // Form Processing
        $result = $this->user->create( $input );

        if ($result['success']) {

            // Success!
            Session::flash('success', $result['message']);

            return Redirect::to('/admin/user/user');

        } else {
            Session::flash('error', $result['message']);

            return Redirect::to('/admin/user/user/create')->withErrors($result['errors'])->withInput();
        }
    }

    public function checkActive()
    {

       return $this->theme->of('user::user.admin.checkActive')->render();

   }
    /**
     * Description
     * @param  type $id
     * @return type
     */
    public function show($id)
    {
        $data['user']           = $this->user->byId($id);
        $data['permissions']    = $this->permissions();

        if ($data['user'] == null || !is_numeric($id)) {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }

        return $this->theme->of('user::user.admin.show', $data)->render();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int      $id
     * @return Response
     */
    public function edit($id)
    {
        $data['user'] = $this->user->byId($id);


        if ($data['user'] == null || !is_numeric($id)) {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
        }

        $currentGroups          = $data['user']->getGroups()->toArray();
        $data['userGroups']     = array();
        foreach ($currentGroups as $group) {
            array_push($data['userGroups'], $group['name']);
        }
        $data['allGroups']  = $this->group->all();
        Former::populate($data['user']);

        return $this->theme ->of('user::user.admin.edit', $data)->render();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int      $id
     * @return Response
     */
    public function getEdit($id, $type)
    {
        $data['user'] = $this->user->byId($id);
        $data['type'] = $type;


        if ($data['user'] == null || !is_numeric($id)) {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
        }

        $currentGroups          = $data['user']->getGroups()->toArray();
        $data['userGroups']     = array();
        foreach ($currentGroups as $group) {
            array_push($data['userGroups'], $group['name']);
        }
        $data['allGroups']  = $this->group->all();
        Former::populate($data['user']);

        return $this->theme ->of('user::user.admin.edit', $data)->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int      $id
     * @return Response
     */
    public function update($id)
    {
        if (!is_numeric($id)) {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }
        $result = $this -> user ->update($id, Input::all());
        if ($result['success']) {
            // Success!
            Session::flash('success', $result['message']);

            return Redirect::to('/admin/user/user');

        } else {
            Session::flash('error', $result['message']);

            return Redirect::to('UserAdminController@edit', array($id))
            ->withInput()
            ->withErrors( $this->userForm->errors() );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int      $id
     * @return Response
     */
    public function destroy($id)
    {
        if (!is_numeric($id)) {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }

        if ($this->user->destroy($id)) {
            Session::flash('success', 'User Deleted');

            return Redirect::to('/admin/user/user');
        } else {
            Session::flash('error', 'Unable to Delete User');

            return Redirect::to('/admin/user/user');
        }
    }

    /**
     * Activate a new user
     * @param  int      $id
     * @param  string   $code
     * @return Response
     */
    public function activate($id, $code)
    {
        if (!is_numeric($id)) {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }

        $result = $this->user->activate($id, $code);

        if ($result['success']) {
            // Success!
            $path = Session::get('url.intended', '/user/profile');
            Session::forget('url.intended');
            return Redirect::to($path);

        } else {
            return Redirect::to('/');
        }

    }

    public function getProfile()
    {

        $id = Sentry::getUser()->id;
        $user['user'] = $this->user->find($id);
        return $this->theme->of('user::user.admin.profile',$user)->render();

    }

    public function viewProfile()
    {

        $id = Sentry::getUser()->id;
        $user['user'] = $this->user->find($id);
        return $this->theme->of('user::user.admin.view',$user)->render();

    }

    public function postProfile()
    {

        $id     = Sentry::getUser()->id;
        $result = $this->user->profileedit($id);
        if ($result['success']) {
            // Success!
            Session::flash('success', $result['message']);
            return Redirect::to('user/profile');

        } else {
            Session::flash('error', $result['message']);
            return Redirect::to('user/profile')
            ->withInput()
            ->withErrors($result['errors']);
        }

    }


    /**
     * Process resend activation request
     * @return Response
     */
    public function resend()
    {
        // Form Processing

        $result = $this->user->resend( Input::all() );

        if ($result['success']) {

            Event::fire('user.resend', array(
                'email' => $result['mailData']['email'],
                'userId' => $result['mailData']['userId'],
                'activationCode' => $result['mailData']['activationCode']
                ));
            // Success!
            Session::flash('success', $result['message']);

            return Redirect::to('login');
        } else {
            Session::flash('error', $result['message']);

            return Redirect::to('resend')
            ->withInput()
            ->withErrors($result['errors']);
        }
    }

    /**
     * Process resend activation request
     * @return Response
     */
    public function getResend()
    {
        // Form Processing
        return $this->theme->of('user::user.admin.resend')->render();

    }

    /**
     * Process Forgot Password request
     * @return Response
     */
    public function forgot()
    {

        // Form Processing
        $result =  $this->user->forgotPassword(Input::all());
        if ($result['success']) {

            // Success!
            Session::flash('success', $result['message']);

            return Redirect::to('/login');
        } else {

            Session::flash('error', $result['message']);
            return Redirect::to('forgot')
            ->withInput()
            ->withErrors($result['errors']);
        }

    }

    /**
     * Show Forgot Password form
     * @return Response
     */
    public function getForgot()
    {
        // Display form
     return $this->theme->of('user::user.admin.forgot')->render();

 }

    /**
     * Process a password reset request link
     * @param  [type] $id   [description]
     * @param  [type] $code [description]
     * @return [type] [description]
     */
    public function reset($id,$code)
    {
        if (!is_numeric($id)) {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }

        $result = $this->user->resetPassword($id, $code);

        if ($result['success']) {
            Event::fire('user.newpassword', array(
                'email' => $result['mailData']['email'],
                'newPassword' => $result['mailData']['newPassword']
                ));

            // Success!
            Session::flash('success', $result['message']);

            return Redirect::to('/login');

        } else {
            Session::flash('error', $result['message']);

            return Redirect::route('/login');
        }
    }

    public function getChange()
    {

       return $this->theme->of('user::user.admin.change')->render();

   }

    /**
     * Process a password change request
     * @param  int      $id
     * @return redirect
     */
    public function postChange()
    {

        $id = Sentry::getUser()->id;
        if (!is_numeric($id)) {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }

        $data = Input::all();
        $data['id'] = $id;

        // Form Processing
        $result = $this->user->changePassword( $data );

        if ($result['success']) {
            // Success!
            Session::flash('success', $result['message']);

            return Redirect::to('\login');
        } else {
            Session::flash('error', $result['message']);
            return Redirect::to('user/change')
            ->withInput()
            ->withErrors($result['errors']);
        }

    }

    /**
     * Process a suspend user request
     * @param  int      $id
     * @return Redirect
     */
    public function getSuspend($id)
    {
        $data['id']     = $id;

        return $this->theme->of('user::user.admin.suspend', $data)->render();

    }

    /**
     * Process a suspend user request
     * @param  int      $id
     * @return Redirect
     */
    public function postSuspend($id)
    {
        if (!is_numeric($id)) {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }

        // Form Processing
        $result = $this->user->suspend($id,  Input::get('minutes') );

        if ($result['success']) {
            // Success!
            Session::flash('success', $result['message']);

            return Redirect::to('admin/user/user');

        } else {
            Session::flash('error', $result['message']);

            return Redirect::action('UserController@suspend', array($id))
            ->withInput()
            ->withErrors( $this->suspendUserForm->errors() );
        }
    }

    /**
     * Unsuspend user
     * @param  int      $id
     * @return Redirect
     */
    public function unsuspend($id)
    {
        if (!is_numeric($id)) {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }

        $result = $this->user->unSuspend($id);

        if ($result['success']) {
            // Success!
            Session::flash('success', $result['message']);

            return Redirect::to('admin/user/user');

        } else {
            Session::flash('error', $result['message']);

            return Redirect::to('admin/user/user');
        }
    }

    /**
     * Ban a user
     * @param  int      $id
     * @return Redirect
     */
    public function ban($id)
    {
        if (!is_numeric($id)) {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }

        $result = $this->user->ban($id);

        if ($result['success']) {
            // Success!
            Session::flash('success', $result['message']);

            return Redirect::to('admin/user/user');

        } else {
            Session::flash('error', $result['message']);

            return Redirect::to('admin/user/user');
        }
    }

    public function unban($id)
    {
        if (!is_numeric($id)) {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }

        $result = $this->user->unBan($id);

        if ($result['success']) {
            // Success!
            Session::flash('success', $result['message']);

            return Redirect::to('admin/user/user');

        } else {
            Session::flash('error', $result['message']);

            return Redirect::to('admin/user/user');
        }
    }

}
