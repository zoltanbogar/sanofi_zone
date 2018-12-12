<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExternalUsersLogTable extends Migration {

	public function up()
	{
		Schema::create('external_users_log', function(Blueprint $table) {
			$table->increments('log_id');
			$table->timestamps();
			$table->string('firstname', 255);
			$table->string('lastname', 255);
			$table->string('email', 100);
			$table->string('company', 100);
			$table->string('phone', 25);
			$table->boolean('status');
			$table->string('site_name', 100);
			$table->datetime('create_date');
			$table->integer('created_by');
		});
	}

	public function down()
	{
		Schema::drop('external_users_log');
	}
}