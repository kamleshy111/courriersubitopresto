<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailWaybillQueuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_waybill_queues', function (Blueprint $table) {
            $table->id();
            $table->string('email_to')->nullable();
            $table->string('email_bcc')->nullable();
            $table->longText('subject')->nullable();
            $table->longText('content')->nullable();
            $table->string('user_name')->nullable();
            $table->tinyInteger('pdf_type')->comment('1=>single, 2=>multiple');
            $table->string('pdf_ids');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_waybill_queues');
    }
}
