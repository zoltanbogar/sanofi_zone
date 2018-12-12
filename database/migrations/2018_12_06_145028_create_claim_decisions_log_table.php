<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClaimDecisionsLogTable extends Migration {

	public function up()
	{
		Schema::create('claim_decisions_log', function(Blueprint $table) {
			$table->increments('log_id');
			$table->integer('user_id');
			$table->integer('claim_id');
			$table->boolean('is_approved');
			$table->datetime('create_date');
			$table->integer('created_by');
			$table->integer('claim_decision_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('claim_decisions_log');
	}
}