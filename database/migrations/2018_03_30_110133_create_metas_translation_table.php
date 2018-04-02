<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetasTranslationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metas_translation', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->unsignedInteger('meta_id');
            $table->unsignedInteger('lang_id');
            $table->text('title');
            $table->text('keywords');
            $table->text('description');

            $table->foreign('meta_id')->references('id')->on('metas')->onDelete('cascade');
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
        Schema::dropIfExists('metas_translation');
    }
}
