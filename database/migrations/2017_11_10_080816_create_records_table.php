<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->string('lang', 20)->nullable();
            $table->string('name');
            $table->string('question1', 1);
            $table->string('question2', 1);
            $table->string('question3', 1);
            $table->string('question4', 1);
            $table->integer('for')->unsigned()->default(0);
            $table->string('result', 4)->nullable();
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
        Schema::dropIfExists('records');
    }
}
