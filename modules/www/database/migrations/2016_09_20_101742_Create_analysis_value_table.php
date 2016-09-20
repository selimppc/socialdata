<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnalysisValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analysis_values', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('analysis_id')->nullable();
            $table->foreign('analysis_id')->references('id')->on('analysis');
            $table->mediumText('value');
            $table->text('end_time');
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
        Schema::drop('analysis_values');
    }
}
