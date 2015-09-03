<?php
namespace Lavalite\User\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Artesaos\Defender\Traits\HasDefender;
use URL;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use HasDefender, Authenticatable, CanResetPassword;


    /**
     * Initialiaze page modal
     *
     * @param $name
     */
    public function __construct()
    {
        parent::__construct();
        $this->initialize();
    }

    /**
     * Initialize the modal variables.
     *
     * @return void
     */
    public function initialize()
    {
        $this->fillable             = config('user.user.fillable');
        $this->uploads              = config('user.user.uploadable');
        $this->uploadRootFolder     = config('user.user.upload_root_folder');
        $this->table                = config('user.user.table');
    }

    /**
     * Name of the user
     *
     * @param mixed $value
     *
     * @return string
     */
    public function getNameAttribute($value){
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Returns the profile picture of the user.
     *
     * @return string image path
     */
    public function getPictureAttribute($value)
    {
        if (!empty($value)) {
            $photo = json_encode($value);
            return URL::to($photo['folder'] . '/' . $photo['file']);
        }

        if ($this->sex == 'Female')
            return URL::to('images/avatar/female.png');

        return URL::to('images/avatar/male.png');

    }

    /**
     * The roles that belong to the user.
     */
    public function roles(){
        return $this->belongsToMany('Lavalite\User\Models\Role');
    }

}
