<?php namespace Lavalite\User;

use App;
use URL;
use View;
use Config;
use Sentry;
use Gravatar;
use Theme;

class User
{

    protected $model;
    protected $user;


    public function __construct(\Lavalite\User\Interfaces\UserInterface $user)
    {
        $this->model    = $user;
    }

    public function id()
    {
        return $this->getUser()->id;
    }

    public function email()
    {
        return $this->getUser()->email;
    }

    public function name()
    {
        return $this->getUser()->first_name . ' ' . $this->getUser()->last_name;
    }

    public function designation()
    {
        return $this->getUser()->designation;
    }

    public function joined()
    {
        return date(' M, Y', strtotime($this->getUser()->created_at));
    }

    public function avatar($width= null, $height = null)
    {
        if ($this->getUser()->sex == 'male') {
            return Theme::asset()->url("img/m3.png");
        } else {
            return Theme::asset()->url("img/f1.png");
        }
    }

    public function getUser(){
        try
        {
            // Get the current active/logged in user
            return  Sentry::getUser();
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            throw $e;
        }
    }
}
