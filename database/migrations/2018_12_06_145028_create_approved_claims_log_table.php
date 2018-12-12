<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateApprovedClaimsLogTable extends Migration {

	public function up()
	{
		Schema::create('approved_claims_log', function(Blueprint $table) {
			$table->increments('log_id');
			$table->timestamps();
			$table->datetime('create_date');
			$table->integer('approved_claims_id')->unsigned();
			$table->integer('claim_id');
		});
	}

	public function down()
	{
		Schema::drop('approved_claims_log');
	}
}