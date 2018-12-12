<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSystemVariablesLogTable extends Migration {

	public function up()
	{
		Schema::create('system_variables_log', function(Blueprint $table) {
			$table->increments('log_id');
			$table->integer('system_variables_id')->unsigned();
			$table->string('key', 255);
			$table->string('value', 255);
			$table->datetime('create_date');
			$table->integer('created_by');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('system_variables_log');
	}
}