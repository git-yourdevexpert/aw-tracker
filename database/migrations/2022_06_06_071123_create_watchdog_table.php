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
        Schema::create('watchdog', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('users_id')->nullable();
            $table->enum('type',['0','1'])->nullable()->default('0');
            $table->mediumText('message',16777215)->nullable();
            $table->mediumText('input',16777215)->nullable();
            $table->mediumText('output',16777215)->nullable();
            $table->string('file',255)->nullable();
            $table->mediumText('url',16777215)->nullable();
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
        Schema::dropIfExists('watchdog');
    }
};
