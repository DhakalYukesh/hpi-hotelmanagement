<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArchivedBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archived_bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->integer('room_id');
            $table->string('check_in');
            $table->string('check_out');
            $table->string('cus_adult');
            $table->string('cus_children');
            $table->string('num_days');
            $table->timestamps();
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('archived_bookings');
    }
}
