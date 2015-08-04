<?php namespace Lavalite\User\Http\Controllers;

use View;
use Input;
use Event;
use Session;
use Redirect;
use Validator;
use Lavalite\User\Interfaces\SessionInterface;

class SessionController extends \PublicController
{
    /**
     * Member Vars
     */
    protected $session;
    protected $loginForm;

    /**
     * Constructor
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
        parent::__construct();
    }

    /**
     * Show the login form
     */
    public function create()
    {
        return $this->theme->of('user::sessions.login')->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {

        $input = Input::all();

        $result	= $this->session->store($input);

        if ($result['success']) {
            Event::fire('user.login', array(
                        'userId' => $result['sessionData']['userId'],
                        'email'  => $result['sessionData']['email']
                        ));

           // Success!
            $path = Session::get('url.intended', '/user/profile');
            Session::forget('url.intended');
            return Redirect::to($path);

        } else {
            Session::flash('error', $result['message']);

            return Redirect::to('login')->withErrors($result['errors'])->withInput();
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
        $this->session->destroy();
        Event::fire('user.logout');

        return Redirect::to('/');
    }

}
