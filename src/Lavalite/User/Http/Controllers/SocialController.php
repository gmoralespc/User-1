<?php namespace Lavalite\User\Http\Controllers;

use Former;
use Illuminate\Http\Response;
use Input;
use View;
use Event;
use User;
use Session;
use Redirect;
use Validator;
use User;

use Lavalite\User\Interfaces\UserInterface;
use Lavalite\User\Interfaces\GroupInterface;
use Lavalite\User\Interfaces\SessionInterface;


class SocialController extends \PublicController
{
    protected $user;
    protected $group;
    protected $session;


    public function __construct(
        UserInterface $user,
        GroupInterface $group,
        SessionInterface $session
    ) {
        $this->user = $user;
        $this->group = $group;
        $this->session = $session;
        parent::__construct();

    }

    /**
     * Login user with facebook
     *
     * @return void
     */

    public function facebook() {

        // get data from input
        $code = Input::get( 'code' );

        // get fb service
        $fb = User::consumer( 'Facebook' );

        // check if code is valid

        // if code is provided get user data and sign in
        if ( !empty( $code ) ) {

            // This was a callback request from facebook, get the token
            $token = $fb->requestAccessToken( $code );

            // Send a request with it
            $result = json_decode( $fb->request( '/me' ), true );
            $res    = $this->user->social('facebook', $result['id'], $result['email']);

            if (User::check())
            {
                return Redirect::to('/user');
            }

            $data['first_name'] = $result['first_name'];
            $data['last_name'] = $result['last_name'];
            $data['facebook'] = $result['id'];
            $data['email'] = $result['email'];
            //$data['mobile'] = $result['mobile']
            Former::populate($data);
            //dd(print_r($result));
            return $this->theme->of('user::user.public.register', $data)->render();


        }
        // if not ask for permission first
        else {
            // get fb authorization
            $url = $fb->getAuthorizationUri();

            // return to facebook login url
            return Redirect::to( (string)$url );
        }

    }

    public function google() {

        // get data from input
        $code = Input::get( 'code' );

        // get google service
        $googleService = User::consumer( 'Google' );

        // check if code is valid

        // if code is provided get user data and sign in
        if ( !empty( $code ) ) {

            // This was a callback request from google, get the token
            $token = $googleService->requestAccessToken( $code );

            // Send a request with it
            $result = json_decode( $googleService->request( 'https://www.googleapis.com/oauth2/v1/userinfo' ), true );

            $message = 'Your unique Google user id is: ' . $result['id'] . ' and your name is ' . $result['name'];
            echo $message. "<br/>";

            //Var_dump
            //display whole array().
            dd($result);

        }
        // if not ask for permission first
        else {
            // get googleService authorization
            $url = $googleService->getAuthorizationUri();

            // return to google login url
            return Redirect::to( (string)$url );
        }
    }

    public function twitter() {

        // get data from input
        $token = Input::get( 'oauth_token' );
        $verify = Input::get( 'oauth_verifier' );

        // get twitter service
        $tw = User::consumer( 'Twitter' );

        // check if code is valid

        // if code is provided get user data and sign in
        if ( !empty( $token ) && !empty( $verify ) ) {

            // This was a callback request from twitter, get the token
            $token = $tw->requestAccessToken( $token, $verify );

            // Send a request with it
            $result = json_decode( $tw->request( 'account/verify_credentials.json' ), true );

            $message = 'Your unique Twitter user id is: ' . $result['id'] . ' and your name is ' . $result['name'];
            echo $message. "<br/>";

            //Var_dump
            //display whole array().
            dd($result);

        }
        // if not ask for permission first
        else {
            // get request token
            $reqToken = $tw->requestRequestToken();

            // get Authorization Uri sending the request token
            $url = $tw->getAuthorizationUri(array('oauth_token' => $reqToken->getRequestToken()));

            // return to twitter login url
            return Redirect::to( (string)$url );
        }
    }

    public function linkedin() {

        // get data from input
        $code = Input::get( 'code' );

        $linkedinService = User::consumer( 'Linkedin' );


        if ( !empty( $code ) ) {

            // This was a callback request from linkedin, get the token
            $token = $linkedinService->requestAccessToken( $code );
            // Send a request with it. Please note that XML is the default format.
            $result = json_decode($linkedinService->request('/people/~?format=json'), true);

            // Show some of the resultant data
            echo 'Your linkedin first name is ' . $result['firstName'] . ' and your last name is ' . $result['lastName'];


            //Var_dump
            //display whole array().
            dd($result);

        }// if not ask for permission first
        else {
            // get linkedinService authorization
            $url = $linkedinService->getAuthorizationUri(array('state'=>'DCEEFWF45453sdffef424'));

            // return to linkedin login url
            return Redirect::to( (string)$url );
        }


    }

}
