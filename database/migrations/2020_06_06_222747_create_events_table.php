<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('caption')->nullable();
            $table->string('description')->nullable();
            $table->text('short_text')->nullable();
            $table->text('long_text')->nullable();
            $table->json('image')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('event_user', function(Blueprint $table) {
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('user_id');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_user');
        Schema::dropIfExists('events');
    }
}
