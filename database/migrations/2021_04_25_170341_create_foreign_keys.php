<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('clients', function(Blueprint $table) {
			$table->foreign('city_id')->references('id')->on('cities')
						->onDelete('no action')
						->onUpdate('no action');
		});
		Schema::table('waybills', function(Blueprint $table) {
			$table->foreign('shipper_id')->references('id')->on('clients')
						->onDelete('no action')
						->onUpdate('no action');
		});
		Schema::table('waybills', function(Blueprint $table) {
			$table->foreign('recipient_id')->references('id')->on('clients')
						->onDelete('no action')
						->onUpdate('no action');
		});
	}

	public function down()
	{
		Schema::table('clients', function(Blueprint $table) {
			$table->dropForeign('clients_city_id_foreign');
		});
		Schema::table('waybills', function(Blueprint $table) {
			$table->dropForeign('waybills_shipper_id_foreign');
		});
		Schema::table('waybills', function(Blueprint $table) {
			$table->dropForeign('waybills_recipient_id_foreign');
		});
	}
}