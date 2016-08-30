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
            $table->unsignedInteger('company_id',false);
            $table->foreign('company_id')->references('id')->on('company');
            $table->enum('status',['new','sent']);
            $table->unsignedInteger('postId');
            $table->integer('created_by',false);
            $table->integer('updated_by',false);
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
