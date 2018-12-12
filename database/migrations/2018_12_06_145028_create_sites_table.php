<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSitesTable extends Migration {

	public function up()
	{
		Schema::create('sites', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 255);
			$table->integer('parent_id');
			$table->boolean('status')->default(true);
			$table->datetime('create_date');
			$table->datetime('modify_date');
			$table->integer('created_by');
			$table->integer('modified_by');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('sites');
	}
}