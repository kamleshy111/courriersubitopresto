<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttachDataExtensionToEmailWaybillQueuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('email_waybill_queues', function (Blueprint $table) {
            $table->string('attach_data_extension')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('email_waybill_queues', function (Blueprint $table) {
            $table->dropColumn('attach_data_extension');
        });
    }
}
