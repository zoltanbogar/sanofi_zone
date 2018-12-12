<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRejectedClaimsLogTable extends Migration {

	public function up()
	{
		Schema::create('rejected_claims_log', function(Blueprint $table) {
			$table->increments('log_id');
			$table->timestamps();
			$table->integer('claim_id');
			$table->text('justification');
			$table->datetime('create_date');
			$table->integer('rejected_claim_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('rejected_claims_log');
	}
}