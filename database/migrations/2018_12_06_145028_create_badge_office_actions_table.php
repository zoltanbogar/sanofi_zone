<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBadgeOfficeActionsTable extends Migration {

	public function up()
	{
		Schema::create('badge_office_actions', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('user_id')->unsigned();
			$table->integer('claim_id')->unsigned();
			$table->boolean('is_seen')->default(true);
			$table->boolean('is_handled')->default(false);
			$table->datetime('create_date');
			$table->datetime('modify_date');
		});
	}

	public function down()
	{
		Schema::drop('badge_office_actions');
	}
}