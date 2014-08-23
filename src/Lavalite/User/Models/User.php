<?php namespace Lavalite\User\Models;

use Validator;

use Eloquent;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends \Cartalyst\Sentry\Users\Eloquent\User implements UserInterface, RemindableInterface
{
    /**
     * Error message bag
     *
     * @var Illuminate\Support\MessageBag
     */
    protected $errors;

    /**
     * Holds all validation rules
     *
     * @var MessageBag
     */
    public static $rules = array(
            'email'                     => 'required|min:4|max:32|email',
            'password'                  => 'required|min:6|confirmed',
            'password_confirmation'     => 'required',
            'recaptcha_response_field'  => 'required|recaptcha',
            );


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password');

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }

    /**
     * Return remembarable token
     * @return string
     */
    public function getRememberToken()
    {
        return $this->email;
    }
    public function setRememberToken($value)
    {
        return $this->email;
    }
    public function getRememberTokenName()
    {
        return $this->email;
    }

    public function getPersistCode()
    {
        if (!$this->persist_code)
        {
            $this->persist_code = $this->getRandomString();

            // Our code got hashed
            $persistCode = $this->persist_code;

            $this->save();

            return $persistCode;
        }
        return $this->persist_code;
    }
}
