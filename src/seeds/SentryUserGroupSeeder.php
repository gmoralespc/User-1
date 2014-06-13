<?php

class SentryUserGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_groups')->delete();

        $userUser = Sentry::getUserProvider()->findByLogin('user@user.com');
        $adminUser = Sentry::getUserProvider()->findByLogin('admin@admin.com');
        $superUser = Sentry::getUserProvider()->findByLogin('superadmin@superadmin.com');
        $developerUser = Sentry::getUserProvider()->findByLogin('developer@developer.com');

        $userGroup = Sentry::getGroupProvider()->findByName('Users');
        $adminGroup = Sentry::getGroupProvider()->findByName('Admins');
        $superGroup = Sentry::getGroupProvider()->findByName('Super Admins');
        $developerGroup = Sentry::getGroupProvider()->findByName('Developers');

        // Assign the groups to the users
        $userUser->addGroup($userGroup);
        $adminUser->addGroup($adminGroup);
        $superUser->addGroup($superGroup);
        $developerUser->addGroup($developerGroup);
    }

}
