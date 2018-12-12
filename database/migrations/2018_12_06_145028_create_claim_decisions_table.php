<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClaimDecisionsTable extends Migration {

	public function up()
	{
		Schema::create('claim_decisions', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('user_id')->unsigned();
			$table->integer('claim_id')->unsigned();
			$table->boolean('is_approved')->default(true);
			$table->datetime('create_date');
			$table->datetime('modify_date');
		});
	}

	public function down()
	{
		Schema::drop('claim_decisions');
	}
}