<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostSocialMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_social_media', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('custom_post_id',false);
            $table->foreign('custom_post_id')->references('id')->on('custom_posts');
            $table->unsignedInteger('social_media_id',false);
            $table->foreign('social_media_id')->references('id')->on('sm_type');
            $table->enum('status',['new','sent']);
            $table->unsignedInteger('postId');
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
        Schema::drop('post_social_media');
    }
}
