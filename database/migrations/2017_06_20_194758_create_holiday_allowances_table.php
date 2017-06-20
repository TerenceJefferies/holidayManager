<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHolidayAllowancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holiday_allowances', function (Blueprint $table) {
            $table->increments('id');
            $table -> integer('user_id') -> unsigned();
            $table -> foreign('user_id') -> references('id') -> on('users');
            $table -> double('days',3,1);
            $table -> double('used_days',3,1);
            $table -> dateTime('starts');
            $table -> dateTime('expires');
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
        Schema::dropIfExists('holiday_allowances');
    }
}
