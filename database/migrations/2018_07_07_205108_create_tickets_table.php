<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
	        $table->unsignedInteger('game_id');
	        $table->unsignedInteger('user_id');
	        $table->string('numbers', 255);
	        $table->tinyInteger('special_number')->unsigned()->nullable();
	        $table->timestamps();

	        $table->foreign('game_id')->references('id')->on('games');
	        $table->foreign('user_id')->references('id')->on('users');
	        $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
