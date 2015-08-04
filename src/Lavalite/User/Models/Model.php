<?php
namespace Lavalite\User\Models;

use DB;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent
{

    public function __construct($attributes = array()) {
        $this->initialize();
        parent::__construct($attributes);
    }

    public function initialize()
    {
    }

}
