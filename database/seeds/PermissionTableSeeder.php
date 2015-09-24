<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class PermissionTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('permissions')->insert(array(
            array(
                'name' => 'user.user.view',
                'readable_name' => 'View user'
            ),
            array(
                'name' => 'user.user.create',
                'readable_name' => 'Create user'
            ),
            array(
                'name' => 'user.user.edit',
                'readable_name' => 'Update user'
            ),
            array(
                'name' => 'user.user.delete',
                'readable_name' => 'Delete user'
            )

        ));
    }
}
