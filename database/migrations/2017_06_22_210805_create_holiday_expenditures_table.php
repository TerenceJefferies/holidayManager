<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHolidayExpendituresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holiday_expenditures', function (Blueprint $table) {
          $table->increments('id');
          $table -> integer('allowance_id') -> unsigned();
          $table -> foreign('allowance_id') -> references('id') -> on('holiday_allowances');
          $table -> double('days',3,1);
          $table -> date('starts');
          $table -> date('ends');
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
        Schema::dropIfExists('holiday_expenditures');
    }
}
