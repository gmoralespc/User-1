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


    protected $fillable = ['id', 'name', 'readable_name', 'created_at', 'updated_at'];


   /**
     * Listen for save and updating event
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {

            $model->upload();
            //$model->slug = !empty($model->slug) ? Str::slug($model->slug) : $model->getUniqueSlug($model->name);
        });

    }


}
