<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuelStation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fuel_station', function (Blueprint $table) {
            $table->id();
            $table->string('district_id')->nullable();
            $table->string('suberb_id')->nullable();
            $table->string('name')->nullable();
            $table->double('max_volume')->default(0);
            $table->double('min_volume')->default(0);
            $table->double('available_volume')->default(0);
            $table->string('secret_code')->nullable();
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
        Schema::dropIfExists('fuel_station');
    }
}
