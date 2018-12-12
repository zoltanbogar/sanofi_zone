<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->string('firstname', 255);
			$table->string('lastname', 255);
			$table->string('company', 100);
			$table->string('site_name', 100);
			$table->string('email', 100);
			$table->string('phone', 25);
			$table->boolean('status')->default(true);
            $table->rememberToken();
            $table->string('confirmation_token')->nullable();
            $table->timestamp('logged_in_at')->nullable();
            $table->timestamps();
            $table->timestamp('confirmed_at')->nullable();
            $table->integer('deleted_by')->unsigned()->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->string('password', 60)->nullable();
            $table->timestamp('password_updated_at')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('users');
	}
}