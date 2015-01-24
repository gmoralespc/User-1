<?php namespace  Lavalite\User\Repositories\Eloquent;

use Cartalyst\Sentry\Sentry;
use Lavalite\User\Interfaces\SessionInterface;
use URL, Validator, Event;

class SessionRepository extends BaseRepository implements SessionInterface
{
    protected $sentry;
    protected $throttleProvider;

    public function __construct(Sentry $sentry)
    {
        $this->sentry = $sentry;

        // Get the Throttle Provider
        $this->throttleProvider = $this->sentry->getThrottleProvider();

        // Enable the Throttling Feature
        $this->throttleProvider->enable();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($data)
    {
        
        $result = array();
        $rules = array(
            
            'email'                 => 'required|min:4|max:32|email',
            'password'              => 'required|min:6|max:32',

        );
        
        //Run input validation
        $v = Validator::make($data, $rules);

        if ($v->fails()) {
            // Validation has failed
            $result['success']  = false;
            $result['message']  = trans('users.invalidinputs');

        } else {

                try {
                        // Check for 'rememberMe' in POST data
                        if (!array_key_exists('rememberMe', $data)) $data['rememberMe'] = 0;

                        //Check for suspension or banned status
                        $user     = \Sentry::getUserProvider()->findByLogin(e($data['email']));
                        $throttle = \Sentry::getThrottleProvider()->findByUserId($user->id);
                        $throttle->check();

                        // Set login credentials
                        $credentials = array(
                            'email'    => e($data['email']),
                            'password' => e($data['password'])
                        );

                        // Try to authenticate the user
                        $user = \Sentry::authenticate($credentials, e($data['rememberMe']));
                        \Sentry::logout();
                        \Sentry::login($user,  e($data['rememberMe']));
                        $result['success'] = true;
                        $result['sessionData']['userId'] = $user->id;
                        $result['sessionData']['email'] = $user->email;
                    } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
                    // Sometimes a user is found, however hashed credentials do
                    // not match. Therefore a user technically doesn't exist
                    // by those credentials. Check the error message returned
                    // for more information.
                    $result['success'] = false;
                    $result['message'] = trans('user::sessions.invalid');
                    } catch (\Cartalyst\Sentry\Users\UserNotActivatedException $e) {
                        $result['success'] = false;
                        $url = URL::to('resend');
                        $result['message'] = trans('user::sessions.notactive', array('url' => $url));
                    }
                        // The following is only required if throttle is enabled
                    catch (\Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
                    $time = $throttle->getSuspensionTime();
                    $result['success'] = false;
                    $result['message'] = trans('user::sessions.suspended');
                    } catch (\Cartalyst\Sentry\Throttling\UserBannedException $e) {
                        $result['success'] = false;
                        $result['message'] = trans('user::sessions.banned');
                    }

                }

                //Login was succesful.
            $result['errors']   = $v;
            return $result;
    }

    public function authenticate($data){

        $result = array();
        $rules = array(
            
            'email'                 => 'required|min:4|max:32|email',
            'password'              => 'required|min:6|max:32',

        );
        
        //Run input validation
        $v = Validator::make($data, $rules);

        if ($v->fails()) {

            // Validation has failed
            $result['success']  = false;
            $result['message']  = trans('users.invalidinputs');

        } else {


            try {
                       
                        // Set login credentials
                        $credentials = array(
                            'email'    => e($data['email']),
                            'password' => e($data['password'])
                        );

                        // Try to authenticate the user
                        $user = \Sentry::authenticate($credentials);
                        \Sentry::logout();
                        \Sentry::login($user);
                        $result['success'] = true;
                        $result['sessionData']['userId'] = $user->id;
                        $result['sessionData']['email'] = $user->email;

                } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
                    // Sometimes a user is found, however hashed credentials do
                    // not match. Therefore a user technically doesn't exist
                    // by those credentials. Check the error message returned
                    // for more information
                    $result['success'] = false;
                    $result['message'] = trans('user::sessions.invalid');
                } catch (\Cartalyst\Sentry\Users\UserNotActivatedException $e) {
                        $result['success'] = false;
                        $url = URL::to('resend');
                        $result['message'] = trans('user::sessions.notactive', array('url' => $url));
                }
                        // The following is only required if throttle is enabled
                catch (\Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
                    $time = $throttle->getSuspensionTime();
                    $result['success'] = false;
                    $result['message'] = trans('user::sessions.suspended');
                } catch (\Cartalyst\Sentry\Throttling\UserBannedException $e) {
                        $result['success'] = false;
                        $result['message'] = trans('user::sessions.banned');
                }

        }

        $result['errors']   = $v;
        return $result;
    }

    public function authenticateAndRemember($data){

        $result = array();
        $rules = array(
            
            'email'                 => 'required|min:4|max:32|email',
            'password'              => 'required|min:6|max:32',

        );
        
        //Run input validation
        $v = Validator::make($data, $rules);

        if ($v->fails()) {

            // Validation has failed
            $result['success']  = false;
            $result['message']  = trans('users.invalidinputs');

        } else {


            try {
                       
                        // Set login credentials
                        $credentials = array(
                            'email'    => e($data['email']),
                            'password' => e($data['password'])
                        );

                        // Try to authenticate the user
                        $user = \Sentry::authenticateAndRemember($credentials);
                        \Sentry::logout();
                        \Sentry::login($user);
                        $result['success'] = true;
                        $result['sessionData']['userId'] = $user->id;
                        $result['sessionData']['email'] = $user->email;

                } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
                    // Sometimes a user is found, however hashed credentials do
                    // not match. Therefore a user technically doesn't exist
                    // by those credentials. Check the error message returned
                    // for more information
                    $result['success'] = false;
                    $result['message'] = trans('user::sessions.invalid');
                } catch (\Cartalyst\Sentry\Users\UserNotActivatedException $e) {
                        $result['success'] = false;
                        $url = URL::to('resend');
                        $result['message'] = trans('user::sessions.notactive', array('url' => $url));
                }
                        // The following is only required if throttle is enabled
                catch (\Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
                    $time = $throttle->getSuspensionTime();
                    $result['success'] = false;
                    $result['message'] = trans('user::sessions.suspended');
                } catch (\Cartalyst\Sentry\Throttling\UserBannedException $e) {
                        $result['success'] = false;
                        $result['message'] = trans('user::sessions.banned');
                }

        }

        $result['errors']   = $v;
        return $result;

    }

    public function loginAndRemember($data){

        $result = array();
        $rules = array(
            
            'email'                 => 'required|min:4|max:32|email',
            'password'              => 'required|min:6|max:32',

        );
        
        //Run input validation
        $v = Validator::make($data, $rules);

        if ($v->fails()) {

            // Validation has failed
            $result['success']  = false;
            $result['message']  = trans('users.invalidinputs');

        } else {


            try {
                       
                        // Set login credentials
                        $credentials = array(
                            'email'    => e($data['email']),
                            'password' => e($data['password'])
                        );

                        // Try to authenticate the user
                        $user = \Sentry::loginAndRemember($credentials);
                        \Sentry::logout();
                        \Sentry::login($user);
                        $result['success'] = true;
                        $result['sessionData']['userId'] = $user->id;
                        $result['sessionData']['email'] = $user->email;

                } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
                    // Sometimes a user is found, however hashed credentials do
                    // not match. Therefore a user technically doesn't exist
                    // by those credentials. Check the error message returned
                    // for more information
                    $result['success'] = false;
                    $result['message'] = trans('user::sessions.invalid');
                } catch (\Cartalyst\Sentry\Users\UserNotActivatedException $e) {
                        $result['success'] = false;
                        $url = URL::to('resend');
                        $result['message'] = trans('user::sessions.notactive', array('url' => $url));
                }
                        // The following is only required if throttle is enabled
                catch (\Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
                    $time = $throttle->getSuspensionTime();
                    $result['success'] = false;
                    $result['message'] = trans('user::sessions.suspended');
                } catch (\Cartalyst\Sentry\Throttling\UserBannedException $e) {
                        $result['success'] = false;
                        $result['message'] = trans('user::sessions.banned');
                }

        }

        $result['errors']   = $v;
        return $result;

    }
    public function check(){

        if ( ! \Sentry::check())
        {
            
            return $result['success'] = false;
        }
        else
        { 

            return $result['success'] = true;
    
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int      $id
     * @return Response
     */
    public function destroy()
    {
        $this->sentry->logout();
    }

}
