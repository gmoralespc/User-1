<?php

return array(

    /**
     * Provider .
     */

    'provider' => 'lavalite',

    /**
     * package .
     */

    'package' => 'user',

    'modules' => ['user', 'group'],


	/**
     * Storage
     */
	'storage' => 'Session',

	/**
     * Consumers
     */
	'consumers' => array(

        /**
         * Facebook
         */
        'Facebook' => array(
            'client_id' => '1535279790019746',
            'client_secret' => '18d77a170c775e0f2d14b5da52f83e54',
            'scope' => array('email','read_friendlists','user_online_presence'),
        ),

        /**
         * Twitter
         */
        'Twitter' => array(
            'client_id' => 'cbYabHCbmUwZmicZpIsjwr5zD',
            'client_secret' => 'qQ6eoTxAJt8MozQZuvCeCJ8rCosXWPUuAvhAsRRa3f5cdLcYEe'
        ),

        'Linkedin' => array(
            'client_id'     => '75heo6ghrhuf9u',
            'client_secret' => 'rCFWVDYXFIbiQHUT',
        ),
        'Google' => array(
            'client_id'     => '705841137880-ek56g6cm93nb2klvlkgf8geekevdr6mc.apps.googleusercontent.com',
            'client_secret' => 'ZTpLZKnjAYncTIse2xyNMWJO',
            'scope'         => array('userinfo_email', 'userinfo_profile'),
        ),
    ),
    'group' =>array(
        'name'          => 'Product',
        'table'         => 'catalogue_products',
        'model'         => 'Lavalite\Catalogue\Models\Product',
        'permissions'   => ['admin' => ['view', 'create', 'edit', 'delete', 'image']],
        'image'         =>
            [
            'xs'        => ['width' =>'60',     'height' =>'45'],
            'sm'        => ['width' =>'160',    'height' =>'75'],
            'md'        => ['width' =>'460',    'height' =>'345'],
            'lg'        => ['width' =>'800',    'height' =>'600'],
            'xl'        => ['width' =>'1000',   'height' =>'750'],
            ],

    ),
    'user' => array(
        'name'          => 'Product',
        'table'         => 'catalogue_products',
        'model'         => 'Lavalite\Catalogue\Models\Product',
        'permissions'   => ['admin' => ['view', 'create', 'edit', 'delete', 'image'],
                            'test' => ['view', 'create', 'edit', 'delete', 'image']],
        'image'         =>
            [
            'xs'        => ['width' =>'60',     'height' =>'45'],
            'sm'        => ['width' =>'160',    'height' =>'75'],
            'md'        => ['width' =>'460',    'height' =>'345'],
            'lg'        => ['width' =>'800',    'height' =>'600'],
            'xl'        => ['width' =>'1000',   'height' =>'750'],
            ],

        'fillable'              => ['first_name', 'last_name', 'sex', 'date_of_birth', 'designation', 'mobile',
                                    'phone', 'address', 'address1', 'address2', 'street', 'city', 'district', 'state',
                                    'country', 'web', 'facebook', 'twitter', 'google', 'linkedin'],
        'translatable'          => [],
        'upload_root_folder'    => '/packages/lavalite/user/user/',
        'uploadable'            => ['single' => ['photo']],
        'table'                 => 'users',
    )
);