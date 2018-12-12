<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateZonesLogTable extends Migration {

	public function up()
	{
		Schema::create('zones_log', function(Blueprint $table) {
			$table->increments('log_id');
			$table->timestamps();
			$table->string('name');
			$table->integer('site_id');
			$table->boolean('status');
			$table->datetime('create_date');
			$table->integer('created_by');
			$table->integer('zone_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('zones_log');
	}
}