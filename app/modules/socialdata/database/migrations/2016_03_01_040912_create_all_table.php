<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //sm_type (social media type) table
        Schema::create('sm_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type',64);
            $table->text('access_token');
            $table->string('code');
            $table->enum('status',array('active','inactive','cancel'))->nullable();
            $table->integer('created_by', false, 11);
            $table->integer('updated_by', false, 11);
            $table->timestamps();
            $table->unique(array('type'));
        });

        //company table
        Schema::create('company', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',64);
            $table->enum('status',array('active','inactive','cancel'))->nullable();
            $table->integer('created_by', false, 11);
            $table->integer('updated_by', false, 11);
            $table->timestamps();
        });

        //company_social_account
        Schema::create('company_social_account', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sm_account_id');
            $table->string('page_id');
            $table->integer('company_id', false, 11);
            $table->string('access_token');
            $table->string('associate_token');
            $table->boolean('ac_status')->comment('Account Status');
            $table->boolean('p_status')->comment('Page Status');
            $table->integer('sm_type_id', false, 11);
            $table->string('data_pull_duration',10);
            $table->enum('status',array('active','inactive','cancel'))->nullable();
            $table->integer('created_by', false, 11);
            $table->integer('updated_by', false, 11);
            $table->timestamps();
            $table->unique(['company_id', 'sm_type_id']);
        });
        Schema::table('company_social_account', function($table) {
            $table->foreign('company_id')->references('id')->on('company');
            $table->foreign('sm_type_id')->references('id')->on('sm_type');
        });

        // post table
        Schema::create('post', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id', false, 11);
            $table->integer('sm_type_id', false, 11);
            $table->text('post');
            $table->integer('mention', false, 1);
            $table->string('post_id',255);
            $table->string('post_date',64);
            $table->string('post_update',64);
            $table->integer('created_by', false, 11);
            $table->integer('updated_by', false, 11);
            $table->timestamps();
            $table->unique(array('post_id'));
        });
        Schema::table('post', function($table) {
            $table->foreign('company_id')->references('id')->on('company');
            $table->foreign('sm_type_id')->references('id')->on('sm_type');
        });

        // comment table
        Schema::create('comment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_id', false, 11);
            $table->string('comment_id',255);
            $table->text('comment');
            $table->string('comment_date',64);
            $table->integer('created_by', false, 11);
            $table->integer('updated_by', false, 11);
            $table->timestamps();
            $table->unique(array('comment_id'));
        });
        Schema::table('comment', function($table) {
            $table->foreign('post_id')->references('id')->on('post');
        });

        DB::unprepared(file_get_contents("app/modules/socialdata/database/sql_dump/company.sql"));
        DB::unprepared(file_get_contents("app/modules/socialdata/database/sql_dump/sm_type.sql"));
        DB::unprepared(file_get_contents("app/modules/socialdata/database/sql_dump/company_social_account.sql"));
        /*DB::unprepared(file_get_contents("app/modules/socialdata/database/sql_dump/post.sql"));*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('comment');
        Schema::drop('post');
        Schema::drop('sm_type');
        Schema::drop('company');
        Schema::drop('company_social_account');
    }
}
