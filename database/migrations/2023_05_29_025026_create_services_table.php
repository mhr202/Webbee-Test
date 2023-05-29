<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('slot_duration')->default(20);
            $table->integer('after_service_time')->default(5);
            $table->integer('capacity')->default(1);
            $table->integer('booking_time_limit')->default(5);
            $table->unsignedBigInteger('business_administrator_id');
            $table->foreign('business_administrator_id')->references('id')->on('business_administrators')->onDelete('cascade');
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
        Schema::dropIfExists('services');
    }
}
