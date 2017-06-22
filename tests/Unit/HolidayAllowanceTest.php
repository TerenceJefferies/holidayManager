<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HolidayAllowanceTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * Tests to ensure the a holiday allowance object is always as expected
     *
     * @return void
     */
    public function xtestSuccessfullAllowanceRetrieval()
    {
      //Given The user has been setup, configured and an allowance has been issued
      //Where The user requests the number of days they have remaining for holiday
      //Then The HolidayAllowance class returns the data in an appropriate format

      $user = factory('App\HolidayManager\User\User') -> create();
      factory('App\HolidayManager\HolidayTime\HolidayAllowance') -> create(['user_id' => $user -> id]);
      $this -> assertInstanceOf('Illuminate\Database\Eloquent\Collection',$allowance);
    }
}
