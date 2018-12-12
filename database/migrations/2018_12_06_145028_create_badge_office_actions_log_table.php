<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBadgeOfficeActionsLogTable extends Migration {

	public function up()
	{
		Schema::create('badge_office_actions_log', function(Blueprint $table) {
			$table->increments('log_id');
			$table->timestamps();
			$table->integer('user_id');
			$table->integer('claim_id');
			$table->boolean('is_seen');
			$table->boolean('is_handled');
			$table->datetime('create_date');
			$table->integer('created_by');
			$table->integer('badge_office_action_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('badge_office_actions_log');
	}
}