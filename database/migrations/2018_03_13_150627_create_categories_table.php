<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('parent_id');
            $table->unsignedInteger('autometa_id');
            $table->string('alias')->nullable();
            $table->string('image');
            $table->boolean('deleted')->default(0);
            $table->tinyInteger('level')->nullable();
            $table->tinyInteger('position')->nullable();

            $table->foreign('autometa_id')->references('id')->on('autometas');


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
        Schema::dropIfExists('categories');
    }
}
