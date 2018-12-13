<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClaimsTable extends Migration {

	public function up()
	{
		Schema::create('claims', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('claimer_user_id')->unsigned();
			$table->integer('target_user_id')->unsigned();
			$table->boolean('is_external_target')->default(false);
			$table->integer('zone_id')->unsigned();
			$table->datetime('authorized_from');
			$table->datetime('authorized_to');
			$table->string('job_type');
			$table->boolean('status')->default(true);
			$table->boolean('is_draft')->default(false);
			$table->datetime('claim_date');
			$table->datetime('create_date');
		});
	}

	public function down()
	{
		Schema::drop('claims');
	}
}