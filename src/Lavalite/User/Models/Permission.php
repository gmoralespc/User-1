<?php namespace Lavalite\User\Models;

use Str;
use Config;
use Lavalite\Filer\FilerTrait;
use Illuminate\Database\Eloquent\Model;


class Permission extends Model
{
    use FilerTrait;


    protected $table        = 'permissions';

    protected $module       = 'permission';

    protected $package      = 'user';


    protected $fillable = ['name', 'readable_name'];



}
