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
        Schema::create('company', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('address1', 255)->nullable();
            $table->string('address2', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->char('state', 3)->nullable();
            $table->char('zip', 9)->nullable();
            $table->string('country', 255)->nullable();
            $table->enum('status', ['0', '1'])->default('0')->nullable(); // 0 = NOT_VERIFIED, 1 = VERIFIED
            $table->timestamp('c_time')->useCurrent();
            $table->string('stripe_token', 255)->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company');
    }
};
