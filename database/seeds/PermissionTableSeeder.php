<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class PermissionTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('permissions')->insert(array(

        ));
    }
}
