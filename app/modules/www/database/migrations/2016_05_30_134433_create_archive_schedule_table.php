<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArchiveScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archive_schedule', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('custom_post_id',false);
            $table->foreign('custom_post_id')->references('id')->on('custom_posts');
            $table->timestamp('time');
            $table->integer('schedule_created_by',false);
            $table->integer('schedule_updated_by',false);
            $table->timestamp('schedule_created_at');
            $table->timestamp('schedule_updated_at');
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
        Schema::drop('archive_schedule');
    }
}
