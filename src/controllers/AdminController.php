<?php namespace Lavalite\User\Controllers;

use View;
use Input;
use Event;
use Session;
use Redirect;
use Validator;
use Lavalite\User\Interfaces\SessionInterface;

class AdminController extends \AdminController
{
    /**
     * Member Vars
     */
    protected $session;
    protected $loginForm;

    /**
     * Constructor
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
        parent::__construct();
    }


}
