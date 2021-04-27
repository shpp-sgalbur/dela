<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDela extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dela', function (Blueprint $table) {
            
            $table->id();            
            $table->bigInteger('user_id');
            $table->string('category');
            $table->text('content');
            $table->integer('votes')->nullable();
            $table->integer('rating');
            
            $table->foreign('user_id')->references('id')->on('users');
            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dela');
    }
}
