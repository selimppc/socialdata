<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('post_image', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('post_id');
            $table->foreign('post_id')->references('id')->on('post');
            $table->text('url_low')->nullable();
            $table->text('url_thumbnail')->nullable();
            $table->text('url_standard')->nullable();
            $table->integer('created_by', false, 11);
            $table->integer('updated_by', false, 11);
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
        Schema::drop('post_image');
    }
}
