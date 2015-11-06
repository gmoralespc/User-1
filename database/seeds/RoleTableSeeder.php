<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RoleTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('permissions')->insert([
            [
                'name'          => 'user.role.view',
                'readable_name' => 'View Role'
            ],
            [
                'name'          => 'user.role.create',
                'readable_name' => 'Create Role'
            ],
            [
                'name'          => 'user.role.edit',
                'readable_name' => 'Update Role'
            ],
            [
                'name'          => 'user.role.delete',
                'readable_name' => 'Delete Role'
            ]
        ]);

        DB::table('roles')->insert([
            [
                'id'   => 1,
                'name' => 'superuser'
            ],
            [
                'id'   => 2,
                'name' => 'admin'
            ],
            [
                'id'   => 3,
                'name' => 'user'
            ],
        ]);
    }
}
