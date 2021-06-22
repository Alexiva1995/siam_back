<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserFavContent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_user', function(Blueprint $table) {
            $table->unsignedBigInteger('store_id');
            $table->unsignedBigInteger('user_id');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('store_id')->references('id')->on('stores');
            $table->foreign('user_id')->references('id')->on('users');
        });
       
        Schema::create('discount_user', function(Blueprint $table) {
            $table->unsignedBigInteger('discount_id');
            $table->unsignedBigInteger('user_id');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('discount_id')->references('id')->on('discounts');
            $table->foreign('user_id')->references('id')->on('users');
        });
        
        Schema::create('news_user', function(Blueprint $table) {
            $table->unsignedBigInteger('news_id');
            $table->unsignedBigInteger('user_id');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('news_id')->references('id')->on('news');
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
        Schema::dropIfExists('news_user');
        Schema::dropIfExists('discount_user');
        Schema::dropIfExists('store_user');
    }
}
