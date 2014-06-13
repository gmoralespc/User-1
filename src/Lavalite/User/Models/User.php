<?php namespace Lavalite\User\Models;

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


    /**
     * Validates current attributes against rules
     *
     * @return bool
     */
    public function validate()
    {
        $validator = Validator::make($this->attributes, static::$rules);

        if ($validator->passes()) {
            return true;
        }

        $this->setErrors($validator->messages());

        return false;
    }

    /**
     * Set error message bag
     *
     * @var Illuminate\Support\MessageBag
     * @return void
     */
    protected function setErrors(MessageBag $errors)
    {
        $this->errors = $errors;
    }

    /**
     * Retrieve error message bag
     *
     * @return Illuminate\Support\MessageBag
     */
    public function getErrors()
    {
        return $this->errors instanceof MessageBag ? $this->errors : new MessageBag;
    }

    /**
     * Check if a model has been saved
     *
     * @return boolean
     */
    public function isSaved()
    {
        return $this->errors instanceof MessageBag ? false : true;
    }

    /**
     * Create a unique slug
     *
     * @param  string $title
     * @return void
     */
    protected function getUniqueSlug($title)
    {
        $slug = Str::slug($title);

        $row = DB::table($this->table)->where('slug', $slug)->first();

        if ($row) {
            $num = 2;
            while ($row) {
                $newSlug = $slug .'-'. $num;

                $row = DB::table($this->table)->where('slug', $newSlug)->first();
                $num++;
            }

            $slug = $newSlug;
        }

        return $slug;
    }

    /**
     * Create a unique slug
     *
     * @param  string $title
     * @return void
     */
    protected function getModule()
    {
        return $this->module;
    }

   /**
     * Listen for save and updating event
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

    }

}
