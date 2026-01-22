<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration {

	public function up()
	{
		Schema::create('clients', function(Blueprint $table) {
			$table->increments('id');
			$table->string('prefix', 6);
			$table->string('name', 50);
			$table->string('phone', 10);
			$table->string('address', 70);
			$table->integer('city_id')->unsigned();
			$table->string('postal_code', 7);
            $table->string('contact', 70)->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('clients');
	}
}
