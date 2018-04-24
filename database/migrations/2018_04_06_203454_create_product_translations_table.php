<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('lang_id');
            $table->string('alias');
            $table->string('name');
            $table->text('body');
            $table->string('seo_h1');
            $table->string('seo_title');
            $table->string('seo_keywords');
            $table->text('seo_description');

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
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
        Schema::dropIfExists('product_translations');
    }
}
