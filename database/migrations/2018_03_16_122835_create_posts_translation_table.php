<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTranslationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts_translation', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->unsignedInteger('lang_id');
            $table->unsignedInteger('post_id');
            $table->string('title');
            $table->text('body');
            $table->string('slug');
            $table->string('url');
            $table->string('meta_h1');
            $table->string('meta_title');
            $table->string('meta_keywords');
            $table->text('meta_description');

            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('lang_id')->references('id')->on('lang')->onDelete('cascade');


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
        Schema::dropIfExists('posts_translation');
    }
}
