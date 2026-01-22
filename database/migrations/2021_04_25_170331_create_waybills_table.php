<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWaybillsTable extends Migration {

	public function up()
	{
		Schema::create('waybills', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('soft_id')->unsigned()->index();
			$table->integer('shipper_id')->unsigned();
			$table->integer('recipient_id')->unsigned();
			$table->date('date');
			$table->enum('who_pay', array('shipper', 'recipient', 'other'));
			$table->enum('status', array('night', 'code_red', 'very_urgent', 'urgent', 'same_day', 'tomorrow', 'tomorrow_48h'));
			$table->string('description')->nullable();
			$table->text('details')->nullable();
			$table->string('cost_1', 50)->nullable();
			$table->string('cost_2', 50)->nullable();
			$table->string('hazardous_materials_1', 50)->nullable();
			$table->string('hazardous_materials_2', 50)->nullable();
			$table->string('weight_1', 50)->nullable();
			$table->string('weight_2', 50)->nullable();
			$table->string('cubing_1', 50)->nullable();
			$table->string('cubing_2', 50)->nullable();
			$table->string('waiting_time_1', 50)->nullable();
			$table->string('waiting_time_2', 50)->nullable();
			$table->boolean('round_trip_1')->nullable();
			$table->string('round_trip_2', 50)->nullable();
			$table->string('truck_1', 50)->nullable();
			$table->string('truck_2', 50)->nullable();
			$table->string('total', 50)->nullable();
            $table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('waybills');
	}
}
