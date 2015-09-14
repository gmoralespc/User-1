<?php
namespace Lavalite\User\Models;

use Lavalite\Filer\FilerTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Artesaos\Defender\Traits\HasDefender;
use URL;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use HasDefender, Authenticatable, CanResetPassword, FilerTrait, SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'photo' => 'array',
    ];

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
     * Returns the joined date of the user.
     *
     * @return string date
     */
    public function getJoinedAttribute()
    {
        return $this->created_at->format(config('cms.format.date'));
    }

    /**
     * The roles that belong to the user.
     */
    public function roles(){
        return $this->belongsToMany('Lavalite\User\Models\Role');
    }

}
