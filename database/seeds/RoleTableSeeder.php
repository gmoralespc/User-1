<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RoleTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('permissions')->insert(array(
            array(
                'name' => 'user.role.view',
                'readable_name' => 'View Role'
            ),
            array(
                'name' => 'user.role.create',
                'readable_name' => 'Create Role'
            ),
            array(
                'name' => 'user.role.edit',
                'readable_name' => 'Update Role'
            ),
            array(
                'name' => 'user.role.delete',
                'readable_name' => 'Delete Role'
            )
        ));

        DB::table('roles')->insert(array(
            [
                'id' => 1,
                'name' => 'superuser'
            ],
            [
                'id' => 2,
                'name' => 'admin'
            ],
            [
                'id' => 3,
                'name' => 'user'
            ],
        ));
    }
}
