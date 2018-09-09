<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTicketsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table( 'tickets', function ( Blueprint $table ) {
			$table->dropColumn('special_number');
			$table->string('special_numbers', 255)->nullable();;
			$table->float('price');
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table( 'tickets', function ( Blueprint $table ) {
			$table->string('special_number')->nullable();;
			$table->dropColumn('special_numbers');
			$table->dropColumn('price');
		} );
	}
}
