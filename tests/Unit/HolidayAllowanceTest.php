<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\HolidayManager\HolidayTime\HolidayAllowanceRepository;
use App\HolidayManager\HolidayTime\HolidayTimeCalculator;
use App\HolidayManager\HolidayTime\HolidayExpenditureRepository;

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
      $repo = new HolidayExpenditureRepository();
      $expenditures = $repo -> getExpendituresForAllowance($allowance);
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
      $repo = new HolidayExpenditureRepository();
      $expenditures = $repo -> getExpendituresForAllowance($allowance);
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
      factory('App\HolidayManager\HolidayTime\HolidayExpenditure') -> create(['allowance_id' => $allowance -> id,'days' => 5,'status' => 'approved']);
      $repo = new HolidayExpenditureRepository();
      $expenditures = $repo -> getExpendituresForAllowance($allowance);
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
        'days' => 5,
        'status' => 'approved'
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
      $correctResult = factory('App\HolidayManager\HolidayTime\HolidayExpenditure') -> create(['allowance_id' => $allowance -> id,'days' => 2,'status' => 'approved','starts' => \Carbon\Carbon::now() -> addDays(5) -> toDateTImeString()]);
      factory('App\HolidayManager\HolidayTime\HolidayExpenditure') -> create(['allowance_id' => $allowance -> id,'days' => 2,'status' => 'approved','starts' => \Carbon\Carbon::now() -> addDays(10) -> toDateTimeString()]);
      $repo = new HolidayExpenditureRepository();
      $nextExpenditure = $repo -> getNextExpenditureForAllowance($allowance);
      $this -> assertEquals($correctResult -> id,$nextExpenditure -> id);
    }

    /**
      Tests to ensure that unapproved the next unapproved holiday can be
      retrieved

      @return void
    */
    public function testGetNextUnapprovedHoliday() {
      $user = factory('App\HolidayManager\User\User') -> create();
      $allowance = factory('App\HolidayManager\HolidayTime\HolidayAllowance') -> create(['user_id' => $user -> id,'days' => 10]);
      $correctResult = factory('App\HolidayManager\HolidayTime\HolidayExpenditure') -> create(['allowance_id' => $allowance -> id,'days' => 2,'status' => 'rejected','starts' => \Carbon\Carbon::now() -> addDays(5) -> toDateTImeString()]);
      factory('App\HolidayManager\HolidayTime\HolidayExpenditure') -> create(['allowance_id' => $allowance -> id,'days' => 2,'status' => 'approved','starts' => \Carbon\Carbon::now() -> addDays(10) -> toDateTimeString()]);
      $repo = new HolidayExpenditureRepository();
      $nextExpenditure = $repo -> getNextExpenditureForAllowance($allowance,true);
      $this -> assertEquals($correctResult -> id,$nextExpenditure -> id);
    }

    /**
      Test to ensure that unapproved expenditures are not returned if told not
      to do so

      @return void
    */
    public function testHideUnapprovedExpenditures() {
      $user = factory('App\HolidayManager\User\User') -> create();
      $allowance = factory('App\HolidayManager\HolidayTime\HolidayAllowance') -> create(['user_id' => $user -> id,'days' => 10]);
      factory('App\HolidayManager\HolidayTime\HolidayExpenditure') -> create(['allowance_id' => $allowance -> id,'days' => 5,'status' => 'rejected']);
      $repo = new HolidayExpenditureRepository();
      $expenditures = $repo -> getExpendituresForAllowance($allowance,false);
      $calculator = new HolidayTimeCalculator($allowance);
      $remainingDays = $calculator -> calculateRemainingDays($expenditures);
      $this -> assertEquals($expenditures -> count(), 0);
    }

    /**
      Ensures that only the appropriate number of elements are returned from
      the expenditure gathering method

      @return void
    */
    public function testGetExpendituresWithLimit() {
      $user = factory('App\HolidayManager\User\User') -> create();
      $allowance = factory('App\HolidayManager\HolidayTime\HolidayAllowance') -> create(['user_id' => $user -> id,'days' => 10]);
      factory('App\HolidayManager\HolidayTime\HolidayExpenditure',10) -> create(['allowance_id' => $allowance -> id,'days' => 5,'status' => 'approved']);
      $repo = new HolidayExpenditureRepository();
      $expenditures = $repo -> getExpendituresForAllowance($allowance,true,5);
      $calculator = new HolidayTimeCalculator($allowance);
      $remainingDays = $calculator -> calculateRemainingDays($expenditures);
      $this -> assertEquals(5,$expenditures -> count());
    }

    /**
      Tests to ensure holiday expenditures can be retrieved by status

      @return void
    */
    public function testGetExpendituresForAllowanceByStatus() {
      $user = factory('App\HolidayManager\User\User') -> create();
      $allowance = factory('App\HolidayManager\HolidayTime\HolidayAllowance') -> create(['user_id' => $user -> id,'days' => 10]);
      factory('App\HolidayManager\HolidayTime\HolidayExpenditure') -> create(['allowance_id' => $allowance -> id,'days' => 5,'status' => 'approved']);
      factory('App\HolidayManager\HolidayTime\HolidayExpenditure') -> create(['allowance_id' => $allowance -> id,'days' => 5,'status' => 'approved']);
      factory('App\HolidayManager\HolidayTime\HolidayExpenditure') -> create(['allowance_id' => $allowance -> id,'days' => 5,'status' => 'rejected']);
      factory('App\HolidayManager\HolidayTime\HolidayExpenditure') -> create(['allowance_id' => $allowance -> id,'days' => 5,'status' => 'pending']);
      $repo = new HolidayExpenditureRepository();
      $approvedExpenditures = $repo -> getExpendituresForAllowanceByStatus($allowance,'approved');
      $this -> assertEquals(2,$approvedExpenditures -> count());
      $mixedExpenditures = $repo -> getExpendituresForAllowanceByStatus($allowance,['approved','pending']);
      $this -> assertEquals(3,$mixedExpenditures -> count());
    }

    /**
      Tests to ensure holiday expenditures can be retrieved by status can be
      limited

      @return void
    */
    public function testGetExpendituresForAllowanceByStatusLimited() {
      $user = factory('App\HolidayManager\User\User') -> create();
      $allowance = factory('App\HolidayManager\HolidayTime\HolidayAllowance') -> create(['user_id' => $user -> id,'days' => 10]);
      factory('App\HolidayManager\HolidayTime\HolidayExpenditure') -> create(['allowance_id' => $allowance -> id,'days' => 5,'status' => 'approved']);
      factory('App\HolidayManager\HolidayTime\HolidayExpenditure') -> create(['allowance_id' => $allowance -> id,'days' => 5,'status' => 'approved']);
      factory('App\HolidayManager\HolidayTime\HolidayExpenditure') -> create(['allowance_id' => $allowance -> id,'days' => 5,'status' => 'approved']);
      $repo = new HolidayExpenditureRepository();
      $limitedExpenditures = $repo -> getExpendituresForAllowanceByStatus($allowance,'approved',2);
      $this -> assertEquals(2,$limitedExpenditures -> count());
    }

    /**
      Tests to ensure we can get an allowance by ID wth and without rules
      applied

      @return void
    */
    public function testGetAllowanceById() {
      $user = factory('App\HolidayManager\User\User') -> create();
      $targetAllowance = factory('App\HolidayManager\HolidayTime\HolidayAllowance') -> create([
        'user_id' => $user -> id,
        'days' => 10,
        'starts' => \Carbon\Carbon::now() -> subDays(10) -> toDateTimeString(),
        'ends' => \Carbon\Carbon::now() -> subDays(5) -> toDateTimeString()
      ]);
      $repo = new HolidayAllowanceRepository();
      $allowance = $repo -> getById($targetAllowance -> id);//The new allowance is expired and we are following the rules, we expect nothing back
      $this -> assertNull($allowance);
      $allowance = $repo -> getById($targetAllowance -> id,true);//The new allowance is expired and we are following the rules, we expect nothing back
      $this -> assertInstanceOf('App\HolidayManager\HolidayTime\HolidayAllowance',$allowance);
      $this -> assertEquals($targetAllowance -> id, $allowance -> id);
    }
}
