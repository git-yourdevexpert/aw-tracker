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
        Schema::create('trail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('visit_id')->nullable();
            $table->string('url', 1023)->nullable();
            $table->string('title', 511)->nullable();
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
        Schema::dropIfExists('trail');
    }
};
