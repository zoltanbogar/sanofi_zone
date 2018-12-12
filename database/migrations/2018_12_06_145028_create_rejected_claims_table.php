<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRejectedClaimsTable extends Migration {

	public function up()
	{
		Schema::create('rejected_claims', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('claim_id')->unsigned();
			$table->text('justification');
			$table->datetime('create_date');
		});
	}

	public function down()
	{
		Schema::drop('rejected_claims');
	}
}