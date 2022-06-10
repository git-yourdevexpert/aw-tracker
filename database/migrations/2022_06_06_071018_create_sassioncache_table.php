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
        Schema::create('sessioncache', function (Blueprint $table) {
            $table->integer('visit_id')->nullable();
            $table->binary('sid', 16)->nullable();
            $table->binary('uid', 16)->nullable();
            $table->char('token', 32)->nullable();
            $table->integer('expiry')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessioncache');
    }
};
