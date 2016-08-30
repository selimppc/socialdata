<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyMetricTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_metrics', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('company_id',false);
            $table->foreign('company_id')->references('id')->on('company');
            $table->unsignedInteger('metric_id',false);
            $table->foreign('metric_id')->references('id')->on('metrics');
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
        Schema::drop('company_metrics');
    }
}
