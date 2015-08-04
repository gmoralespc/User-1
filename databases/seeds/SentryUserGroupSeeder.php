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

        $userUser = User::getUserProvider()->findByLogin('user@user.com');
        $adminUser = User::getUserProvider()->findByLogin('admin@admin.com');
        $superUser = User::getUserProvider()->findByLogin('superadmin@superadmin.com');
        $developerUser = User::getUserProvider()->findByLogin('developer@developer.com');

        $userGroup = User::getGroupProvider()->findByName('Users');
        $adminGroup = User::getGroupProvider()->findByName('Admins');
        $superGroup = User::getGroupProvider()->findByName('Super Admins');
        $developerGroup = User::getGroupProvider()->findByName('Developers');

        // Assign the groups to the users
        $userUser->addGroup($userGroup);
        $adminUser->addGroup($adminGroup);
        $superUser->addGroup($superGroup);
        $developerUser->addGroup($developerGroup);
    }

}
