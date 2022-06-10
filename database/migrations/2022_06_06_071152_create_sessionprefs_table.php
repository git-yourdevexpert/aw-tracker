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
        Schema::create('sessionprefs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('users_id')->nullable();
            $table->binary('fields',65535)->nullable();
            $table->timestamp('c_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessionprefs');
    }
};
