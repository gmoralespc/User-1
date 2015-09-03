<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePermissionsTable extends Migration {

        /**
         * Run the migrations.
         *
         * @return void
         */
         public function up()
         {

	    /**
	     * Table: pages
	     */
	       Schema::create('permissions', function($table) {
                $table->increments('id')->unsigned();
                $table->string('name', 50)->nullable();
                $table->string('slug', 50)->nullable();
                $table->integer('order')->nullable();
                $table->boolean('status')->default("1");
                $table->string('upload_folder', 100)->nullable();
                $table->softDeletes();
                $table->nullableTimestamps();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
         public function down()
         {
	            Schema::drop('permissions');
         }

}