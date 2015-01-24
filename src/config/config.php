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

);