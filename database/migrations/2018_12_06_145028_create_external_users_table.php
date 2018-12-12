<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExternalUsersTable extends Migration {

	public function up()
	{
		Schema::create('external_users', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('firstname', 255);
			$table->string('lastname', 255);
			$table->string('email', 100);
			$table->string('company', 100);
			$table->datetime('create_date');
			$table->datetime('modify_date');
			$table->integer('created_by');
			$table->integer('modified_by');
			$table->string('phone', 25);
			$table->boolean('status')->default(true);
			$table->string('site_name', 100);
		});
	}

	public function down()
	{
		Schema::drop('external_users');
	}
}