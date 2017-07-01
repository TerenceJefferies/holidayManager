<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\HolidayManager\HolidayTime\HolidayExpenditureRepository;
use App\HolidayManager\HolidayTime\HolidayAllowanceRepository;

use Carbon\Carbon;

class HolidayExpenditureTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * A user to use with this test set
     * @var App\HolidayManager\User
     */
    private $user;

    /**
     * Holiday allowance retrieval class
     * @var App\HolidayManager\HolidayTime\HolidayAllowanceRepositoryInterface
     */
    private $holidayAllowanceRepository;

    /**
     * Holiday expenditure retrieval class
     * @var App\HolidayManager\HolidayTime\HolidayExpenditureRepositoryInterface
     */
    private $holidayExpenditureRepository;

    /**
     * A re-usable allowance
     * @var App\HolidayManager\HolidayTime\HolidayAllowanceInterface
     */
    private $allowance;

    /**
     * A re-usable expenditure
     * @var App\HolidayManager\HolidayTime\HolidayExpenditureInterface
     */
    private $expenditure;

    /**
     * Performs setup methods for the test
     * @param HolidayExpenditureRepositoryInterface $holidayExpenditureRepository
     * @param HolidayAllowanceRepositoryInterface   $holidayAllowanceRepository
     */
    public function setUp() {
      parent::setUp();
      $this -> user = factory('App\HolidayManager\User\User') -> create();
      $this -> holidayExpenditureRepository = new HolidayExpenditureRepository();
      $this -> holidayAllowanceRepository = new holidayAllowanceRepository();
      $this -> allowance = factory('App\HolidayManager\HolidayTime\HolidayAllowance') -> create(['days' => 99]);
      $this -> expenditure = factory('App\HolidayManager\HolidayTime\HolidayExpenditure') -> create(['allowance_id' => $this -> allowance -> id]);
    }

    /**
     * Tests the method used to get expenditures by their ID
     */
    public function testGetByExpenditureId() {
      $expenditure = $this -> holidayExpenditureRepository -> getByExpenditureId($this -> expenditure -> id);
      $this -> assertInstanceOf('App\HolidayManager\HolidayTime\HolidayExpenditureInterface',$expenditure);
      $this -> assertEquals($this -> expenditure -> id,$expenditure -> id);
    }

    /**
     * Test to ensure that an expenditure can be created
     *
     */
    public function testCreateExpenditure()
    {
        $startDate = Carbon::now();
        $targetDays = 1;
        $createdExpenditure = $this -> holidayExpenditureRepository -> createByAllowanceId($this -> allowance -> id,$startDate,$targetDays);
        $this -> assertInstanceOf('App\HolidayManager\HolidayTime\HolidayExpenditureInterface',$createdExpenditure);
        $this -> assertEquals($createdExpenditure -> days,$targetDays);
        $this -> assertEquals($createdExpenditure -> allowance_id,$this -> allowance -> id);
        $this -> assertEquals($createdExpenditure -> starts -> toDateString(),$startDate -> toDateString());
        $databaseExpenditure = $this -> holidayExpenditureRepository -> getByExpenditureId($createdExpenditure -> id);
        $this -> assertEquals($createdExpenditure -> id,$databaseExpenditure -> id);
        $this -> assertEquals($createdExpenditure -> days,$databaseExpenditure -> days);
        $this -> assertEquals($createdExpenditure -> starts,$databaseExpenditure -> starts);
        $this -> assertEquals($createdExpenditure -> allowance_id,$databaseExpenditure -> allowance_id);
    }

}
