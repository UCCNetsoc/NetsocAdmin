<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExceptionsTable extends Migration
{
    /**
     * Created by package 'LogEnvelope'
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('exceptions', function (Blueprint $table) {
            $table->increments('id');

            $table->string('host');
            $table->string('method');
            $table->string('fullUrl');
            $table->text('exception');
            $table->text('error');
            $table->string('line');
            $table->string('file');
            $table->string('class');

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('exceptions');
    }
}