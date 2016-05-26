<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSocialAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_social_account', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sm_account_id');
            $table->integer('user_id', false, 11);
            $table->foreign('user_id')->references('id')->on('user');
            $table->integer('sm_type_id', false, 11);
            $table->foreign('sm_type_id')->references('id')->on('sm_type');
            $table->string('data_pull_duration',10);
            $table->enum('status',array('active','inactive','cancel'))->nullable();
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
        Schema::drop('user_social_account');
    }
}
