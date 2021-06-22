<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EnglishSupport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->renameColumn('description_short', 'es_description_short');
            $table->renameColumn('description', 'es_description');
            $table->renameColumn('location', 'es_location');

            $table->string('en_description_short')->after('description_short')->nullable();
            $table->text('en_description')->after('description')->nullable();
            $table->string('en_location')->after('location')->nullable();
        });

        Schema::table('services', function (Blueprint $table) {
            $table->renameColumn('title', 'es_title');
            $table->renameColumn('description', 'es_description');

            $table->string('en_title')->after('title');
            $table->text('en_description')->after('description')->nullable();
        });
        
        Schema::table('discounts', function (Blueprint $table) {
            $table->renameColumn('title', 'es_title');
            $table->renameColumn('caption', 'es_caption');
            $table->renameColumn('description', 'es_description');

            $table->string('en_title')->after('title');
            $table->string('en_caption')->after('caption')->nullable();
            $table->text('en_description')->after('description')->nullable();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->renameColumn('title', 'es_title');
            $table->renameColumn('caption', 'es_caption');
            $table->renameColumn('description', 'es_description');
            $table->renameColumn('short_text', 'es_short_text');
            $table->renameColumn('long_text', 'es_long_text');

            $table->string('en_title')->after('title');
            $table->string('en_caption')->after('caption')->nullable();
            $table->string('en_description')->after('description')->nullable();
            $table->text('en_short_text')->after('short_text')->nullable();
            $table->text('en_long_text')->after('long_text')->nullable();
        });
        
        Schema::table('news', function (Blueprint $table) {
            $table->renameColumn('title', 'es_title');
            $table->renameColumn('caption', 'es_caption');
            $table->renameColumn('description', 'es_description');
            $table->renameColumn('long_text', 'es_long_text');

            $table->string('en_title')->after('title');
            $table->string('en_caption')->after('caption')->nullable();
            $table->string('en_description')->after('description')->nullable();
            $table->text('en_long_text')->after('long_text')->nullable();
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->renameColumn('title', 'es_title');
            $table->renameColumn('body', 'es_body');

            $table->string('en_title')->after('title');
            $table->string('en_body')->after('body');
        });
        
        Schema::table('devices', function (Blueprint $table) {
            $table->string('language')->after('device_type')->default('es');
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->string('language')->after('admin')->default('es');
        });

        Schema::table('slides', function (Blueprint $table) {
            $table->renameColumn('title', 'es_title');
            $table->renameColumn('caption', 'es_caption');
            $table->renameColumn('description_short', 'es_description_short');

            $table->string('en_title')->after('title')->nullable();
            $table->string('en_caption')->after('caption')->nullable();
            $table->string('en_description_short')->after('description_short')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slides', function (Blueprint $table) {
            $table->dropColumn('en_title');
            $table->dropColumn('en_caption');
            $table->dropColumn('en_description_short');

            $table->renameColumn('es_title', 'title');
            $table->renameColumn('es_caption', 'caption');
            $table->renameColumn('es_description_short', 'description_short');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('language');
        });

        Schema::table('devices', function (Blueprint $table) {
            $table->dropColumn('language');
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn('en_title');
            $table->dropColumn('en_body');

            $table->renameColumn('es_title', 'title');
            $table->renameColumn('es_body', 'body');
        });

        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('en_title');
            $table->dropColumn('en_caption');
            $table->dropColumn('en_description');
            $table->dropColumn('en_long_text');

            $table->renameColumn('es_title', 'title');
            $table->renameColumn('es_caption', 'caption');
            $table->renameColumn('es_description', 'description');
            $table->renameColumn('es_long_text', 'long_text');
        });
        
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('en_title');
            $table->dropColumn('en_caption');
            $table->dropColumn('en_description');
            $table->dropColumn('en_short_text');
            $table->dropColumn('en_long_text');

            $table->renameColumn('es_title', 'title');
            $table->renameColumn('es_caption', 'caption');
            $table->renameColumn('es_description', 'description');
            $table->renameColumn('es_short_text', 'short_text');
            $table->renameColumn('es_long_text', 'long_text');
        });

        Schema::table('discounts', function (Blueprint $table) {
            $table->dropColumn('en_title');
            $table->dropColumn('en_caption');
            $table->dropColumn('en_description');

            $table->renameColumn('es_title', 'title');
            $table->renameColumn('es_caption', 'caption');
            $table->renameColumn('es_description', 'description');
        });
        
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('en_title');
            $table->dropColumn('en_description');

            $table->renameColumn('es_title', 'title');
            $table->renameColumn('es_description', 'description');
        });

        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn('en_location');
            $table->dropColumn('en_description');
            $table->dropColumn('en_description_short');

            $table->renameColumn('es_description_short', 'description_short');
            $table->renameColumn('es_description', 'description');
            $table->renameColumn('es_location', 'location');
        });
    }
}
