<?php namespace Lavalite\User\Http\Controllers;

use App;
use Lang;
use View;
use Input;
use Event;
use User;
use Config;
use Former;
use Session;
use Redirect;
use Validator;
use Request;

use Lavalite\User\Http\Requests\ViewUserRequest;
use Lavalite\User\Http\Requests\UpdateUserRequest;
use Lavalite\User\Http\Requests\StoreUserRequest;
use Lavalite\User\Http\Requests\DeleteUserRequest;


use Lavalite\User\Interfaces\UserProviderInterface;
use Lavalite\User\Interfaces\GroupProviderInterface;
use Lavalite\User\Interfaces\SessionInterface;
use App\Http\Controllers\AdminController as AdminController;


class UserAdminController extends AdminController
{
    protected $user;
    protected $group;
    protected $session;


    public function __construct(
        UserProviderInterface $user,
        GroupProviderInterface $group,
        SessionInterface $session)
    {
        $this->user = $user;
        $this->group = $group;
        $this->session = $session;

        parent::__construct();

    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(ViewUserRequest $request)
    {
        return $this->theme->of('user::admin.users.index')->render();
    }

    public function lists(ViewUserRequest $request)
    {
        $array = $this->user->json();
        foreach ($array as $key => $row){
            $array[$key]    = array_only($row, config('user.user.listfields'));
        }
        return array('data' => $array);
    }

    /**
     * Description
     * @param  type $id
     * @return type
     */
    public function show(ViewUserRequest $request, $id)
    {
        $user           = $this->user->findOrNew($id);
        $allGroups      = $this->group->all();

        Former::populate($user);
        if(Request::ajax())
            return view('user::admin.users.show', compact('allGroups', 'user'));

        return $this->theme->of('user::admin.users.show', compact('allGroups', 'user'))->render();
    }

    /**
     * Show the form for creating a new user.
     *
     * @return Response
     */
    public function create(StoreUserRequest $request)
    {
        $user           = $this->user->findOrNew(0);
        $allGroups  = $this->group->all();

        if($request->ajax())
            return view('user::admin.users.create', compact('allGroups','user'));


        return $this->theme->of('user::admin.users.create', compact('allGroups','user'))->render();
    }

    /**
     * Store a newly created user.
     *
     * @return Response
     */
    public function store(StoreUserRequest $request)
    {
        $result     = '';

        $input = Request::all();

        try {
            // Form Processing
            $user = $this->user->create( $input );
            $groups     = $input['groups'];

            if (!empty($groups)) {
                foreach($groups as $key => $group) {
                    $userGroup = User::findGroupById($key);
                    $user->addGroup($userGroup);
                }
            }
        } catch (\Lavalite\User\Exceptions\LoginRequiredException $e) {
            $result     =  'Login field is required.';
        } catch (\Lavalite\User\Exceptions\PasswordRequiredException $e) {
            $result     =  'Password field is required.';
        } catch (\Lavalite\User\Exceptions\UserExistsException $e) {
            $result     =  'User with this login already exists.';
        } catch (Exception $e) {
            $result     =  'User with this login already exists.';
        }

        if ($result == '') {

            // Success!
            Session::flash('success', $result);

            return redirect('/admin/user/user');

        } else {
            Session::flash('error', $result);

            return redirect('/admin/user/user/create')->withErrors($result)->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int      $id
     * @return Response
     */
    public function edit(UpdateUserRequest $request, $id)
    {
        $user = $this->user->findById($id);


        if ($user == null || !is_numeric($id)) {
            return \App::abort(404);
        }

        $currentGroups          = $user->getGroups()->toArray();
        $userGroups     = array();
        foreach ($currentGroups as $group) {
            array_push($userGroups, $group['name']);
        }
        $allGroups  = $this->group->all();

        Former::populate($user);

        if(Request::ajax())
            return view('user::admin.users.edit', compact('user', 'userGroups', 'allGroups'));

        return $this->theme ->of('user::admin.users.edit', compact('user', 'userGroups', 'allGroups'))->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int      $id
     * @return Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $result     = '';

        $input = Request::all();

        try {
            $user = User::findUserById($id);

            // Update group memberships
            $allGroups = $this->group->findAll();

            foreach ($allGroups as $group) {
                if (isset($input['groups'][$group->id])) {
                    //The user should be added to this group
                    $user->addGroup($group);
                } else {
                    // The user should be removed from this group
                    $user->removeGroup($group);
                }
            }

            unset($input['groups']);

            $user->fill($input);

            $user->activated  = (!empty($input['activated'])) ? 1 : 0;

            if (!empty($input['password']))
                $user->password  = $input['password'];
            // Update the user
            if (!$user->save()) {
                $result     =  'User information was not updated';
            }

        } catch (\Lavalite\User\Exceptions\UserExistsException $e) {
            $result     =  'User with this login already exists.';
        } catch (\Lavalite\User\Exceptions\UserNotFoundException $e) {
            $result     =  'User was not found.';
        }

        if ($result == '') {
            // Success!
            Session::flash('success', $result);

            return redirect('/admin/user/user');

        } else {
            Session::flash('error', $result);

            return Redirect::back()
            ->withInput()
            ->withErrors( $this->errors() );
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

        if ($this->user->delete($id)) {
            Session::flash('success', 'User Deleted');

            return redirect('/admin/user/user');
        } else {
            Session::flash('error', 'Unable to Delete User');

            return redirect('/admin/user/user');
        }
    }


    public function checkActive()
    {

       return $this->theme->of('user::admin.users.checkActive')->render();

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
            return redirect($path);

        } else {
            return redirect('/');
        }

    }

    public function getProfile()
    {

        $id = User::getUser()->id;
        $user['user'] = $this->user->find($id);
        return $this->theme->of('user::admin.users.profile',$user)->render();

    }

    public function viewProfile()
    {

        $id = User::getUser()->id;
        $user['user'] = $this->user->find($id);
        return $this->theme->of('user::admin.users.view',$user)->render();

    }

    public function postProfile()
    {

        $id     = User::getUser()->id;
        $result = $this->user->profileedit($id);
        if ($result['success']) {
            // Success!
            Session::flash('success', $result['message']);
            return redirect('user/profile');

        } else {
            Session::flash('error', $result['message']);
            return redirect('user/profile')
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

        $result = $this->user->resend( Request::all() );

        if ($result['success']) {

            Event::fire('user.resend', array(
                'email' => $result['mailData']['email'],
                'userId' => $result['mailData']['userId'],
                'activationCode' => $result['mailData']['activationCode']
                ));
            // Success!
            Session::flash('success', $result['message']);

            return redirect('login');
        } else {
            Session::flash('error', $result['message']);

            return redirect('resend')
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
        return $this->theme->of('user::admin.users.resend')->render();

    }

    /**
     * Process Forgot Password request
     * @return Response
     */
    public function forgot()
    {

        // Form Processing
        $result =  $this->user->forgotPassword(Request::all());
        if ($result['success']) {

            // Success!
            Session::flash('success', $result['message']);

            return redirect('/login');
        } else {

            Session::flash('error', $result['message']);
            return redirect('forgot')
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
     return $this->theme->of('user::admin.users.forgot')->render();

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

            return redirect('/login');

        } else {
            Session::flash('error', $result['message']);

            return Redirect::route('/login');
        }
    }

    public function getChange()
    {

       return $this->theme->of('user::admin.users.change')->render();

   }

    /**
     * Process a password change request
     * @param  int      $id
     * @return redirect
     */
    public function postChange()
    {

        $id = User::getUser()->id;
        if (!is_numeric($id)) {
            // @codeCoverageIgnoreStart
            return \App::abort(404);
            // @codeCoverageIgnoreEnd
        }

        $data = Request::all();
        $data['id'] = $id;

        // Form Processing
        $result = $this->user->changePassword( $data );

        if ($result['success']) {
            // Success!
            Session::flash('success', $result['message']);

            return redirect('\login');
        } else {
            Session::flash('error', $result['message']);
            return redirect('user/change')
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

        return $this->theme->of('user::admin.users.suspend', compact('id'))->render();

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

        $result     = '';

        try
        {
            // Find the user using the user id
            $throttle = User::findThrottlerByUserId($id);

            // Suspend the user
            $throttle->setSuspensionTime(Request::get('minutes'));
        }
        catch (\Lavalite\User\Exceptions\UserNotFoundException $e)
        {
            $result = 'User was not found.';
        }

        if ($result == '') {
            // Success!
            Session::flash('success', 'User suspend for '. Request::get('minutes') .' munutes.');

            return redirect('admin/user/user');

        } else {
            Session::flash('error', $result);

            return Redirect::back();
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

            return redirect('admin/user/user');

        } else {
            Session::flash('error', $result['message']);

            return redirect('admin/user/user');
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

            return redirect('admin/user/user');

        } else {
            Session::flash('error', $result['message']);

            return redirect('admin/user/user');
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

            return redirect('admin/user/user');

        } else {
            Session::flash('error', $result['message']);

            return redirect('admin/user/user');
        }
    }

}
