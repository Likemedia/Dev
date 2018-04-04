<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImageToPostTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts_translation', function(Blueprint $table) {
            $table->string('image');
            $table->string('image_title');
            $table->string('image_alt');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts_translation', function(Blueprint $table) {
            $table->dropColumn('image');
            $table->dropColumn('image_title');
            $table->dropColumn('image_alt');
       });
    }
}
