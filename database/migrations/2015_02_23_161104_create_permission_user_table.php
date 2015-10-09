<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDefenderPermissionUserTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('permission_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('permission_id')->unsigned()->index();
            $table->foreign('permission_id')->references('id')
                  ->on('permissions')
                  ->onDelete('cascade');

            $table->tinyInteger('value')->default(-1);
            $table->timestamp('expires')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('permission_user', function (Blueprint $table) {
            $table->dropForeign('permission_user'.'_user_id_foreign');
            $table->dropForeign('permission_user'.'_'.'permission_id'.'_foreign');
        });

        Schema::drop('permission_user');
    }
}
