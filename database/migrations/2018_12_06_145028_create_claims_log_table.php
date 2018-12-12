<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClaimsLogTable extends Migration {

	public function up()
	{
		Schema::create('claims_log', function(Blueprint $table) {
			$table->increments('log_id');
			$table->timestamps();
			$table->integer('claimer_user_id');
			$table->integer('target_user_id');
			$table->boolean('is_external_target');
			$table->integer('zone_id');
			$table->datetime('authorized_from');
			$table->datetime('authorized_to');
			$table->boolean('status');
			$table->boolean('is_draft');
			$table->datetime('claim_date');
			$table->datetime('create_date');
			$table->integer('created_by');
			$table->integer('claim_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('claims_log');
	}
}