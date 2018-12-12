<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateZonesTable extends Migration {

	public function up()
	{
		Schema::create('zones', function(Blueprint $table) {
			$table->increments('id');
            $table->string('name', 255);
			$table->integer('site_id')->unsigned();
			$table->boolean('status')->default(true);
			$table->integer('created_by');
			$table->integer('modified_by');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('zones');
	}
}