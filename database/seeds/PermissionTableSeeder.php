<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class PermissionTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('permissions')->insert([
            [
                'name'          => 'user.user.view',
                'readable_name' => 'View user'
            ],
            [
                'name'          => 'user.user.create',
                'readable_name' => 'Create user'
            ],
            [
                'name'          => 'user.user.edit',
                'readable_name' => 'Update user'
            ],
            [
                'name'          => 'user.user.delete',
                'readable_name' => 'Delete user'
            ]

        ]);
    }
}
