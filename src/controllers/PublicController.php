<?php namespace Lavalite\User\Controllers;

use Input;
use View;
use Event;
use Sentry;
use Session;
use Redirect;
use Validator;
use Lavalite\User\Interfaces\UserInterface;
use Lavalite\User\Interfaces\GroupInterface;
use Lavalite\User\Interfaces\SessionInterface;


class PublicController extends \UserController
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


        //Check CSRF token on POST
        $this->beforeFilter('csrf', array('on' => 'post'));

        // Set up Auth Filters
        $this->beforeFilter('auth', array('only' => array('change')));
        $this->beforeFilter('inGroup:Admin', array('only' => array('show', 'index', 'destroy', 'suspend', 'unsuspend', 'ban', 'unban', 'edit', 'update')));
        //array('except' => array('create', 'store', 'activate', 'resend', 'forgot', 'reset')));
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $users['users'] = $this->user->all();
        return $this->theme->of('user::user.public.index',$users)->render();
    }

    /**
     * Show the form for creating a new user.
     *
     * @return Response
     */
    public function create()
    {
        return $this->theme->of('user::user.public.register')->render();
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
        $result = $this->user->register($input);

        if ($result['success']) {

            // Success!
            Session::flash('success', $result['message']);

            return Redirect::to('/checkActive');

        } else {
            Session::flash('error', $result['message']);

            return Redirect::to('register')->withErrors($result['errors'])->withInput();
        }
    }

    public function checkActive()
    {

     return $this->theme->of('user::user.public.checkActive')->render();

    }
    /**
     * Description
     * @param  type $id
     * @return type
     */
    public function show($id)
    {
        $user = $this->user->byId($id);

        if ($user == null || !is_numeric($id)) {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }

        return View::make('user::user.public.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int      $id
     * @return Response
     */
    public function edit($id)
    {
        $user = $this->user->byId($id);

        if ($user == null || !is_numeric($id)) {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }

        $currentGroups = $user->getGroups()->toArray();
        $userGroups = array();
        foreach ($currentGroups as $group) {
            array_push($userGroups, $group['name']);
        }
        $allGroups = $this->group->all();

        return View::make('user::user.public.edit')->with('user', $user)->with('userGroups', $userGroups)->with('allGroups', $allGroups);
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

        // Form Processing
        $result = $this->userForm->update( Input::all() );

        if ($result['success']) {
            // Success!
            Session::flash('success', $result['message']);

            return Redirect::action('UserController@show', array($id));

        } else {
            Session::flash('error', $result['message']);

            return Redirect::action('UserController@edit', array($id))
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

            return Redirect::to('/users');
        } else {
            Session::flash('error', 'Unable to Delete User');

            return Redirect::to('/users');
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
            return Redirect::to('user/profile');

        } else {
            return Redirect::to('/');
        }

    }

    public function getProfile()
    {

        $id = Sentry::getUser()->id;
        $user['user'] = $this->user->find($id);
        return $this->theme->of('user::user.public.profile',$user)->render();

    }

    public function viewProfile()
    {

        $id = Sentry::getUser()->id;
        $user['user'] = $this->user->find($id);
        return $this->theme->of('user::user.public.view',$user)->render();

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
        return $this->theme->of('user::user.public.resend')->render();

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
       return $this->theme->of('user::user.public.forgot')->render();

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

         return $this->theme->of('user::user.public.change')->render();

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

        return $this->theme->of('user::user.public.suspend', $data)->render();

    }

    /**
     * Process a suspend user request
     * @param  int      $id
     * @return Redirect
     */
    public function suspend($id)
    {
        if (!is_numeric($id)) {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }

        // Form Processing
        $result = $this->suspendUserForm->suspend( Input::all() );

        if ($result['success']) {
            // Success!
            Session::flash('success', $result['message']);

            return Redirect::to('users');

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

            return Redirect::to('users');

        } else {
            Session::flash('error', $result['message']);

            return Redirect::to('users');
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

            return Redirect::to('users');

        } else {
            Session::flash('error', $result['message']);

            return Redirect::to('users');
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

            return Redirect::to('users');

        } else {
            Session::flash('error', $result['message']);

            return Redirect::to('users');
        }
    }

}
