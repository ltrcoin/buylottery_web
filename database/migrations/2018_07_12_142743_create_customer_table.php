<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fullname', 255);
            $table->string('email', 255)->unique();
            $table->string('tel', 50)->unique();
            $table->string('wallet_btc', 150)->unique();
            $table->date('dob')->nullable();
            $table->tinyInteger('sex')->nullable();
            $table->integer('country');
            $table->string('address', 255)->nullable();
            $table->tinyInteger('status');
            $table->string('portraitimage', 255);
            $table->string('passportimage', 255);
            $table->string('password', 255);
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
        Schema::dropIfExists('customer');
    }
}
