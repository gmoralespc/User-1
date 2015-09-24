<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RoleTableSeeder extends Seeder
{

    public function run()
    {
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
