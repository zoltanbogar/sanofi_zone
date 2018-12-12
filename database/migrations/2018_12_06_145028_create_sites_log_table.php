<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSitesLogTable extends Migration {

	public function up()
	{
		Schema::create('sites_log', function(Blueprint $table) {
			$table->increments('log_id');
			$table->string('name', 255);
			$table->integer('parent_id');
			$table->datetime('create_date');
			$table->integer('created_by');
			$table->integer('site_id')->unsigned();
			$table->timestamps();
			$table->boolean('status');
		});
	}

	public function down()
	{
		Schema::drop('sites_log');
	}
}