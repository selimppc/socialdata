<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnalysisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analysis', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('company_id',false);
            $table->foreign('company_id')->references('id')->on('company');
            $table->unsignedInteger('metric_id',false);
            $table->foreign('metric_id')->references('id')->on('metrics');
            $table->string('period',100)->nullable();
            $table->longText('data',100)->nullable();
            $table->integer('created_by',false)->nullable();
            $table->integer('updated_by',false)->nullable();
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
        Schema::drop('analysis');
    }
}
