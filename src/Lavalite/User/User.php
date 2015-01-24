<?php namespace Lavalite\User;

use App;
use URL;
use View;
use Config;
use Sentry;
use Gravatar;
use Theme;

use \OAuth\ServiceFactory;
use \OAuth\Common\Consumer\Credentials;

class User
{
    /**
     * @var ServiceFactory
     */
    private $_serviceFactory;

    /**
     * Storege name from config
     * @var string
     */
    private $_storage_name = 'Session';

    /**
     * Client ID from config
     * @var string
     */
    private $_client_id;

    /**
     * Client secret from config
     * @var string
     */
    private $_client_secret;

    /**
     * Scope from config
     * @var array
     */
    private $_scope = array();


    protected $model;
    protected $user;


    /**
     * Constructor
     *
     * @param ServiceFactory $serviceFactory - (Dependency injection) If not provided, a ServiceFactory instance will be constructed.
     */
    public function __construct(ServiceFactory $serviceFactory = null, \Lavalite\User\Interfaces\UserInterface $user,

                                                                        \Lavalite\User\Interfaces\SessionInterface $session,
                                                                         \Lavalite\User\Interfaces\GroupInterface $group)
    {
        if (null === $serviceFactory) {
            // Create the service factory
            $serviceFactory = new ServiceFactory();
        }
        $this->_serviceFactory = $serviceFactory;

        $this->model   = $user;
        $this->session = $session;
        $this->group   = $group;
    }

    /**
     * @return mixed
     * @throws Cartalyst\Sentry\Users\UserNotFoundException
     * @throws \Exception
     */
    public function id()
    {
        return $this->getUser()->id;
    }

    /**
     * @return mixed
     * @throws Cartalyst\Sentry\Users\UserNotFoundException
     * @throws \Exception
     */
    public function email()
    {
        return $this->getUser()->email;
    }

    /**
     * @return string
     * @throws Cartalyst\Sentry\Users\UserNotFoundException
     * @throws \Exception
     */
    public function name()
    {
        return $this->getUser()->first_name . ' ' . $this->getUser()->last_name;
    }

    /**
     * @return mixed
     * @throws Cartalyst\Sentry\Users\UserNotFoundException
     * @throws \Exception
     */
    public function designation()
    {
        return $this->getUser()->designation;
    }

    /**
     * @return bool|string
     * @throws Cartalyst\Sentry\Users\UserNotFoundException
     * @throws \Exception
     */
    public function joined()
    {
        return date(' M, Y', strtotime($this->getUser()->created_at));
    }

    /**
     * @param null $width
     * @param null $height
     * @return mixed
     * @throws Cartalyst\Sentry\Users\UserNotFoundException
     * @throws \Exception
     */
    public function avatar($width = null, $height = null)
    {
        if ($this->getUser()->sex == 'male') {
            return Theme::asset()->url("img/m3.png");
        } else {
            return Theme::asset()->url("img/f1.png");
        }
    }

    /**
     * @throws Cartalyst\Sentry\Users\UserNotFoundException
     * @throws \Exception
     */
    public function getUser()
    {
        try {
            // Get the current active/logged in user
            return Sentry::getUser();
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            throw $e;
        }
    }


    /**
     * Detect config and set data from it
     *
     * @param string $service
     */
    public function setConfig($service)
    {
        $this->_storage_name = Config::get('user::storage', 'Session');
        $this->_client_id = Config::get("user::consumers.$service.client_id");
        $this->_client_secret = Config::get("user::consumers.$service.client_secret");
        $this->_scope = Config::get("user::consumers.$service.scope", array());
    }

    /**
     * Create storage instance
     *
     * @param string $storageName
     * @return OAuth\Common\\Storage
     */
    public function createStorageInstance($storageName)
    {
        $storageClass = "\\OAuth\\Common\\Storage\\$storageName";
        $storage = new $storageClass();

        return $storage;
    }

    /**
     * Set the http client object
     *
     * @param string $httpClientName
     * @return void
     */
    public function setHttpClient($httpClientName)
    {
        $httpClientClass = "\\OAuth\\Common\\Http\\Client\\$httpClientName";
        $this->_serviceFactory->setHttpClient(new $httpClientClass());
    }

    /**
     * @param  string $service
     * @param  string $url
     * @param  array $scope
     * @return \OAuth\Common\Service\AbstractService
     */
    public function consumer($service, $url = null, $scope = null)
    {
        // get config
        $this->setConfig($service);

        // get storage object
        $storage = $this->createStorageInstance($this->_storage_name);

        // create credentials object
        $credentials = new Credentials(
            $this->_client_id,
            $this->_client_secret,
            $url ?: URL::current()
        );

        // check if scopes were provided
        if (is_null($scope)) {
            // get scope from config (default to empty array)
            $scope = $this->_scope;
        }

        // return the service consumer object
        return $this->_serviceFactory->createService($service, $credentials, $storage, $scope);

    }

    public function login($data){

        return $this->session->store($data);

    }


    public function logout(){

        return $this->session->destroy();
    }

    public function authenticate($data){

         return $this->session->authenticate($data);
    }


    public function authenticateAndRemember($data){

         return $this->session->authenticateAndRemember($data);
    }

    public function loginAndRemember($data){

         return $this->session->loginAndRemember($data);
    }



    public function check(){

        return $this->session->check();
    }

    public function create($data,$group){

         return $this->model->create($data,$group);
    }

    public function register($data){

         return $this->model->register($data);
    }
    
    public function update($id, $data){

        return $this->model->update($id, $data);
    }


    public function delete($id){

        return $this->model->destroy($id);
    }

    public function activation($id, $code){

        return $this->model->activate($id, $code);
    }

    public function resetPassword($id, $code){

        return $this->model->resetPassword($id, $code);
    }

    public function changePassword($data = array()){

        return $this->model->changePassword($data);
    }

    public function suspend($id, $minutes){

        return $this->model->suspend($id);
    }

    public function unSuspend($id){

        return $this->model->unSuspend($id);

    }

    public function ban($id){

        return $this->model->ban($id);

    }

    public function unBan($id){

        return $this->model->unBan($id);

    }

    public function userById($id){

        return $this->model->byId($id);

    }

    public function all(){

        return $this->model->all();

    }

    public function createGroup($data = array()){

        return $this->group->store($data);

    }

    public function updateGroup($id, $data = array()){

        return $this->group->update($id, $data);

    }

    public function deleteGroup($id){

        return $this->group->destroy($id);

    }

    public function findGroupById($id){

        return $this->group->byId($id);

    }

    public function findGroupByname($name){

        return $this->group->byName($name);

    }

    public function findGroupAll(){

        return $this->group->all();

    }

    public function hasAccess($action){
        return Sentry::getUser()->hasAccess($action);
    }

}