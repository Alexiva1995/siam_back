<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('description_short', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('location', 255)->nullable();
            $table->integer('hour_from')->nullable();
            $table->integer('hour_to')->nullable();
            $table->string('phone_number', 255)->nullable();
            $table->string('url', 255)->nullable();
            $table->json('images')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('stores');
    }
}
