<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutOfStockRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('out_of_stock_request', function (Blueprint $table) {
            $table->id();
            $table->string('station_id')->nullable();
            $table->string('customer_id')->nullable();
            $table->string('reservation_id')->nullable();
            $table->double('request_amount')->default(0);
            $table->timestamp('request_date')->nullable();
            $table->string('read_status')->default(0);
            $table->string('notify_status')->default(0);
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
        Schema::dropIfExists('out_of_stock_request');
    }
}
