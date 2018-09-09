<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterWinningNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'winning_numbers', function ( Blueprint $table ) {
            $table->dropColumn('special_number');
            $table->tinyInteger('special_numbers')->unsigned()->nullable();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'winning_numbers', function ( Blueprint $table ) {
            $table->dropColumn('special_numbers');
        } );
    }
}
