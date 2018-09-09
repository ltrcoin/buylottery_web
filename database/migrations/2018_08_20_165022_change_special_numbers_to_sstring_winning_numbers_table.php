<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSpecialNumbersToSstringWinningNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'winning_numbers', function ( Blueprint $table ) {
            $table->string('special_numbers', 255)->change();
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
