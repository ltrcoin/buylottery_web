<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('alias', 255)->unique();
            $table->text('image')->nullable();
	        $table->tinyInteger('numbers')->unsigned();
	        $table->tinyInteger('min_number')->unsigned();
	        $table->tinyInteger('max_number')->unsigned();
	        $table->boolean('has_special_number')->default(false);
	        $table->tinyInteger('min_special')->unsigned()->nullable();
	        $table->tinyInteger('max_special')->unsigned()->nullable();
	        $table->time('draw_time');
	        $table->string('draw_day', 30);
	        $table->text('description');
            $table->timestamps();
	        $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
