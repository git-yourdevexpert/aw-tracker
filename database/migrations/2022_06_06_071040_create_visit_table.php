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
        Schema::create('visit', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('site_id')->nullable();
            $table->integer('location_id')->nullable();
            $table->integer('device_id')->nullable();
            $table->string('url_host', 255)->nullable();
            $table->string('referer', 1023)->nullable();
            $table->integer('active')->nullable();
            $table->integer('pages')->nullable();
            $table->date('c_date')->nullable();
            $table->integer('c_utime')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visit');
    }
};
