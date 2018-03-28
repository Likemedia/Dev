<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTranslationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories_translation', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('lang_id');
            $table->string('name');
            $table->text('description');
            $table->string('slug');
            $table->string('meta_title');
            $table->string('meta_keywords');
            $table->text('meta_description');
            $table->text('alt_attribute');
            $table->text('image_title');

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
        Schema::dropIfExists('categories_translation');
    }
}
