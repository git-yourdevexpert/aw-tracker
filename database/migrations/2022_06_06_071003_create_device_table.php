<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device', function (Blueprint $table) {
            $table->increments('id');
            $table->binary('uid', 16);
            $table->string('first_name', 255)->nullable();
            $table->unsignedBigInteger('visitor_id')->nullable();
            $table->string('ua', 511)->nullable();
            $table->string('os', 128)->nullable();
            $table->string('browser_name', 128)->nullable();
            $table->string('browser', 255)->nullable();
            $table->string('device_type', 32)->nullable();
            $table->string('device', 128)->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->integer('c_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device');
    }
};
