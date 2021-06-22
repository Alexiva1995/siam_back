<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTablesAddShareUrl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('discounts', function(Blueprint $table) {
            $table->string('share_url')->after('en_description')->nullable();
        });
        Schema::table('events', function(Blueprint $table) {
            $table->string('share_url')->after('image')->nullable();
        });
        Schema::table('news', function(Blueprint $table) {
            $table->string('share_url')->after('image')->nullable();
        });
        Schema::table('stores', function(Blueprint $table) {
            $table->string('share_url')->after('images')->nullable();
        });
        Schema::table('services', function(Blueprint $table) {
            $table->string('share_url')->after('icon')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services', function(Blueprint $table) {
            $table->dropColumn('share_url');
        });
        Schema::table('stores', function(Blueprint $table) {
            $table->dropColumn('share_url');
        });
        Schema::table('news', function(Blueprint $table) {
            $table->dropColumn('share_url');
        });
        Schema::table('events', function(Blueprint $table) {
            $table->dropColumn('share_url');
        });
        Schema::table('discounts', function(Blueprint $table) {
            $table->dropColumn('share_url');
        });
    }
}
