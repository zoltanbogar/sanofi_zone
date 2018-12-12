<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSystemVariablesTable extends Migration {

	public function up()
	{
		Schema::create('system_variables', function(Blueprint $table) {
			$table->increments('id');
			$table->string('key', 255)->unique();
			$table->string('value', 255);
			$table->integer('created_by');
			$table->integer('modified_by');
			$table->datetime('create_date');
			$table->datetime('modify_date');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('system_variables');
	}
}