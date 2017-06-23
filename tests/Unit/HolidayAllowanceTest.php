<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\HolidayManager\HolidayTime\HolidayAllowanceRepository;
use App\HolidayManager\HolidayTime\HolidayTimeCalculator;

class HolidayAllowanceTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * Tests to ensure the a holiday allowance object is always as expected
     *
     * @return void
     */
    public function testSuccessfullAllowanceRetrieval()
    {
      $user = factory('App\HolidayManager\User\User') -> create();
      factory('App\HolidayManager\HolidayTime\HolidayAllowance') -> create(['user_id' => $user -> id]);
      $repo = new HolidayAllowanceRepository();
      $allowance = $repo -> getByUserId($user -> id);
      $this -> assertInstanceOf('App\HolidayManager\HolidayTime\HolidayAllowance',$allowance);
    }

    /**
      Tests to ensure that a request for a user with no allowance returns the
      appropriate value

      @return void
    */
    public function testEmptyAllowanceRetrieval() {
      $user = factory('App\HolidayManager\User\User') -> create();
      $repo = new HolidayAllowanceRepository();
      $allowance = $repo -> getByUserId($user -> id);
      $this -> assertNull($allowance);
    }

    /**
      Tests to ensure we can successfully get an expenditure from an allowance
      repository object

      @return void
    */
    public function testGetExpendituresFromAllowancesSuccessfully() {
      $user = factory('App\HolidayManager\User\User') -> create();
      $allowance = factory('App\HolidayManager\HolidayTime\HolidayAllowance') -> create(['user_id' => $user -> id]);
      factory('App\HolidayManager\HolidayTime\HolidayExpenditure') -> create(['allowance_id' => $allowance -> id]);
      $repo = new HolidayAllowanceRepository();
      $expenditures = $repo -> getExpenditures($allowance);
      $this -> assertContainsOnlyInstancesOf('App\HolidayManager\HolidayTime\HolidayExpenditure',$expenditures);
    }

    /**
      Tests to ensure a request to an allowance for expenditures that has no
      associated expenditures returns the expected result

      @return void
    */
    public function testGetExpendituresFromAllowancesUnsuccessfully() {
      $user = factory('App\HolidayManager\User\User') -> create();
      $allowance = factory('App\HolidayManager\HolidayTime\HolidayAllowance') -> create(['user_id' => $user -> id]);
      $repo = new HolidayAllowanceRepository();
      $expenditures = $repo -> getExpenditures($allowance);
      $this -> assertContainsOnly('null',$expenditures);
    }

    /**
      Tests to ensure that the calculated remaining days returns a result
      correctly

      @return void
    */
    public function testGetRemainingDays() {
      $user = factory('App\HolidayManager\User\User') -> create();
      $allowance = factory('App\HolidayManager\HolidayTime\HolidayAllowance') -> create(['user_id' => $user -> id,'days' => 10]);
      factory('App\HolidayManager\HolidayTime\HolidayExpenditure') -> create(['allowance_id' => $allowance -> id,'days' => 5]);
      $repo = new HolidayAllowanceRepository();
      $expenditures = $repo -> getExpenditures($allowance);
      $calculator = new HolidayTimeCalculator($allowance);
      $remainingDays = $calculator -> calculateRemainingDays($expenditures);
      $this -> assertEquals($remainingDays,5);
    }

    /**
      Tests the summing of holiday expenditures

      @return void
    */
    public function testCaclulateHolidayDaysUsed() {
      $expenditures = factory('App\HolidayManager\HolidayTime\HolidayExpenditure',10) -> make([
        'allowance_id' => 0,
        'days' => 5
      ]);
      $expectedDays = 50;
      $expenditure = HolidayTimeCalculator::calculateHolidayDaysUsed($expenditures);
      $this -> assertEquals($expenditure,$expectedDays);
    }

    /**
      Tests to ensure that the next holiday method returns the closest holiday

      @return void
    */
    public function testGetNextHoliday() {
      $user = factory('App\HolidayManager\User\User') -> create();
      $allowance = factory('App\HolidayManager\HolidayTime\HolidayAllowance') -> create(['user_id' => $user -> id,'days' => 10]);
      $correctResult = factory('App\HolidayManager\HolidayTime\HolidayExpenditure') -> create(['allowance_id' => $allowance -> id,'days' => 2,'starts' => \Carbon\Carbon::now() -> addDays(5) -> toDateTImeString()]);
      factory('App\HolidayManager\HolidayTime\HolidayExpenditure') -> create(['allowance_id' => $allowance -> id,'days' => 2,'starts' => \Carbon\Carbon::now() -> addDays(10) -> toDateTimeString()]);
      $repo = new HolidayAllowanceRepository();
      $nextExpenditure = $repo -> getNextExpenditure($allowance);
      $this -> assertEquals($correctResult -> id,$nextExpenditure -> id);
    }
}
