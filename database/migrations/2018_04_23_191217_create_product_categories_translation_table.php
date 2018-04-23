<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCategoriesTranslationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('product_categories_translation', function (Blueprint $table) {
             $table->engine = 'InnoDB';

             $table->increments('id');
             $table->unsignedInteger('product_category_id');
             $table->unsignedInteger('lang_id');
             $table->string('name');
             $table->text('url');

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
         Schema::dropIfExists('product_categories_translation');
     }
}
