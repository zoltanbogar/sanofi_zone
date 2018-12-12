<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('system_variables_log', function(Blueprint $table) {
			$table->foreign('system_variables_id')->references('id')->on('system_variables')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('sites_log', function(Blueprint $table) {
			$table->foreign('site_id')->references('id')->on('sites')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('zones', function(Blueprint $table) {
			$table->foreign('site_id')->references('id')->on('sites')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('zones_log', function(Blueprint $table) {
			$table->foreign('zone_id')->references('id')->on('zones')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('claims', function(Blueprint $table) {
			$table->foreign('claimer_user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('claims', function(Blueprint $table) {
			$table->foreign('target_user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('claims', function(Blueprint $table) {
			$table->foreign('zone_id')->references('id')->on('zones')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('claims_log', function(Blueprint $table) {
			$table->foreign('claim_id')->references('id')->on('claims')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('claim_decisions', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('claims')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('claim_decisions', function(Blueprint $table) {
			$table->foreign('claim_id')->references('id')->on('claims')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('claim_decisions_log', function(Blueprint $table) {
			$table->foreign('claim_decision_id')->references('id')->on('claim_decisions')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('approved_claims', function(Blueprint $table) {
			$table->foreign('claim_id')->references('id')->on('claims')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('approved_claims_log', function(Blueprint $table) {
			$table->foreign('approved_claims_id')->references('id')->on('approved_claims')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('rejected_claims', function(Blueprint $table) {
			$table->foreign('claim_id')->references('id')->on('claims')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('rejected_claims_log', function(Blueprint $table) {
			$table->foreign('rejected_claim_id')->references('id')->on('rejected_claims')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('badge_office_actions', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('badge_office_actions', function(Blueprint $table) {
			$table->foreign('claim_id')->references('id')->on('claims')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('badge_office_actions_log', function(Blueprint $table) {
			$table->foreign('badge_office_action_id')->references('id')->on('badge_office_actions')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
	}

	public function down()
	{
		Schema::table('system_variables_log', function(Blueprint $table) {
			$table->dropForeign('system_variables_log_system_variables_id_foreign');
		});
		Schema::table('sites_log', function(Blueprint $table) {
			$table->dropForeign('sites_log_site_id_foreign');
		});
		Schema::table('zones', function(Blueprint $table) {
			$table->dropForeign('zones_site_id_foreign');
		});
		Schema::table('zones_log', function(Blueprint $table) {
			$table->dropForeign('zones_log_zone_id_foreign');
		});
		Schema::table('claims', function(Blueprint $table) {
			$table->dropForeign('claims_claimer_user_id_foreign');
		});
		Schema::table('claims', function(Blueprint $table) {
			$table->dropForeign('claims_target_user_id_foreign');
		});
		Schema::table('claims', function(Blueprint $table) {
			$table->dropForeign('claims_zone_id_foreign');
		});
		Schema::table('claims_log', function(Blueprint $table) {
			$table->dropForeign('claims_log_claim_id_foreign');
		});
		Schema::table('claim_decisions', function(Blueprint $table) {
			$table->dropForeign('claim_decisions_user_id_foreign');
		});
		Schema::table('claim_decisions', function(Blueprint $table) {
			$table->dropForeign('claim_decisions_claim_id_foreign');
		});
		Schema::table('claim_decisions_log', function(Blueprint $table) {
			$table->dropForeign('claim_decisions_log_claim_decision_id_foreign');
		});
		Schema::table('approved_claims', function(Blueprint $table) {
			$table->dropForeign('approved_claims_claim_id_foreign');
		});
		Schema::table('approved_claims_log', function(Blueprint $table) {
			$table->dropForeign('approved_claims_log_approved_claims_id_foreign');
		});
		Schema::table('rejected_claims', function(Blueprint $table) {
			$table->dropForeign('rejected_claims_claim_id_foreign');
		});
		Schema::table('rejected_claims_log', function(Blueprint $table) {
			$table->dropForeign('rejected_claims_log_rejected_claim_id_foreign');
		});
		Schema::table('badge_office_actions', function(Blueprint $table) {
			$table->dropForeign('badge_office_actions_user_id_foreign');
		});
		Schema::table('badge_office_actions', function(Blueprint $table) {
			$table->dropForeign('badge_office_actions_claim_id_foreign');
		});
		Schema::table('badge_office_actions_log', function(Blueprint $table) {
			$table->dropForeign('badge_office_actions_log_badge_office_action_id_foreign');
		});
	}
}