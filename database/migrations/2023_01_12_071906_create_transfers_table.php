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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('user_completed_id')->unsigned()->nullable();
            $table->bigInteger('origin_store_id')->unsigned();
            $table->bigInteger('destination_store_id')->unsigned();
            $table->smallInteger('status');
            $table->date('created_date');
            $table->date('completed_date')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('user_completed_id')->references('id')->on('users');
            $table->foreign('origin_store_id')->references('id')->on('stores');
            $table->foreign('destination_store_id')->references('id')->on('stores');
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
        Schema::dropIfExists('transfers');
    }
};
