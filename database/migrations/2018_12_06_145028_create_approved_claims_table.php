<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateApprovedClaimsTable extends Migration {

	public function up()
	{
		Schema::create('approved_claims', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('claim_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('approved_claims');
	}
}