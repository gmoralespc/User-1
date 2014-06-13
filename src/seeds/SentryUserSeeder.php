<?php

class SentryUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        Sentry::getUserProvider()->create(array(
            'email'    => 'superadmin@superadmin.com',
            'password' => 'superadmin',
            'activated' => 1,
        ));

        Sentry::getUserProvider()->create(array(
            'email'    => 'admin@admin.com',
            'password' => 'admin',
            'activated' => 1,
        ));

        Sentry::getUserProvider()->create(array(
            'email'    => 'developer@developer.com',
            'password' => 'developer',
            'activated' => 1,
        ));

        Sentry::getUserProvider()->create(array(
            'email'    => 'user@user.com',
            'password' => 'user',
            'activated' => 1,
        ));

    }

}
