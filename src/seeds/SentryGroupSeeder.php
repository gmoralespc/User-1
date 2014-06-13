<?php

class SentryGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->delete();

        Sentry::getGroupProvider()->create(array(
            'name'        => 'Admins',
            'permissions' => array(
                'superadmin' 	=> 0,
                'admin' 		=> 1,
                'user'	 		=> 0,
                'developer' 	=> 0,
            )));

        Sentry::getGroupProvider()->create(array(
            'name'        => 'Super Admins',
            'permissions' => array(
                'superadmin' 	=> 1,
                'admin' 		=> 1,
                'user'	 		=> 1,
                'developer' 	=> 0,
            )));

        Sentry::getGroupProvider()->create(array(
            'name'        => 'Developers',
            'permissions' => array(
                'superadmin' 	=> 1,
                'admin' 		=> 1,
                'user'	 		=> 1,
                'developer' 	=> 1,
            )));

        Sentry::getGroupProvider()->create(array(
            'name'        => 'Users',
            'permissions' => array(
                'superadmin' 	=> 0,
                'admin' 		=> 0,
                'user'	 		=> 1,
                'developer' 	=> 0,
            )));

    }

}
