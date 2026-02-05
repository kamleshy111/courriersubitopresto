<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ChangeWaybillsPickupImageToText extends Migration
{
    /**
     * Run the migrations.
     * pickup_image may store a JSON array of up to 5 image paths; VARCHAR(255) is too small.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE waybills MODIFY pickup_image TEXT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE waybills MODIFY pickup_image VARCHAR(255) NULL');
    }
}
