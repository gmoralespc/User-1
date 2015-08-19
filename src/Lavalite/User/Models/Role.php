<?php namespace Lavalite\User\Models;

use Str;
use Config;
use Illuminate\Database\Eloquent\Model;


class Role extends Model
{


    protected $table        = 'roles';

    protected $module       = 'role';

    protected $package      = 'user';


    protected $fillable     = ['name'];

}
