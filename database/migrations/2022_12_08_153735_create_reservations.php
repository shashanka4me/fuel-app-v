<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id')->nullable();
            $table->string('station_id')->nullable();
            $table->string('token_no')->nullable();
            $table->double('request_quata')->default(0);
            $table->string('payment_status')->nullable();
            $table->string('payment_method')->nullable();
            $table->timestamp('payment_done_at')->nullable();
            $table->string('reservation_status')->nullable();
            $table->date('reserve_date')->nullable();
            $table->time('reserve_time')->nullable();
            $table->double('amount')->default(0);
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
        Schema::dropIfExists('reservations');
    }
}
