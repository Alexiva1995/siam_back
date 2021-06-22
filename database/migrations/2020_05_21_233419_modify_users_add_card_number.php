<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyUsersAddCardNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('card_number', 16)->nullable()->after('email');
            $table->json('image')->nullable()->after('remember_token');
            $table->date('birthdate')->nullable()->after('image');
            $table->string('phone_number')->nullable()->after('birthdate');
            $table->string('address')->nullable()->after('phone_number');
            $table->string('zip_code', 20)->nullable()->after('address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('card_number');
            $table->dropColumn('birthdate');
            $table->dropColumn('phone_number');
            $table->dropColumn('address');
            $table->dropColumn('zip_code');
        });
    }
}
