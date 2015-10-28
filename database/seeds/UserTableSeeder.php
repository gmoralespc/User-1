<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('permissions')->insert(array(
            array(
                'name' => 'user.permission.view',
                'readable_name' => 'View Permission'
            ),
            array(
                'name' => 'user.permission.create',
                'readable_name' => 'Create Permission'
            ),
            array(
                'name' => 'user.permission.edit',
                'readable_name' => 'Update Permission'
            ),
            array(
                'name' => 'user.permission.delete',
                'readable_name' => 'Delete Permission'
            )
        ));

        DB::table('users')->insert(array(

            array(
                'id' => 1,
                'email' => 'superuser@superuser.com',
                'password' => '$2y$10$bKwW6PzSa1GDOeUTqtTaLOVMutZ12ObeslBfEXPx2pJAL/2B8aB06',
                'active' => 1,
                'name' => 'Super User',
                'sex' => 'Male',
                'dob' => '2014-05-15',
                'designation' => 'Super User',
                'web' => 'http://lavalite.org',
                'created_at' => '2015-09-15',
            ),
        ));

        DB::table('role_user')->insert(array(
            array(
                'user_id' => 1,
                'role_id' => 1,
            ),
        ));
    }
}
