<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('company_id',false);
            $table->foreign('company_id')->references('id')->on('company');
            $table->text('text');
            $table->enum('status',array('new','inactive','cancel','delete','ready','processing','sent'))->comment('New= Newly Created, Cancel= Can view only.no action available, Delete= Only view by Super Admin, Ready= Ready for scheduling, Processing= Schedule already created, Sent= Schedule task done and sent to archive schedule.');
            $table->string('postId');
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
        Schema::drop('custom_posts');
    }
}