<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\HolidayManager\HolidayTime\HolidayAllowance;
use App\HolidayManager\HolidayTime\HolidayAllowanceRepository;
use App\HolidayManager\HolidayTime\HolidayAllowanceRepositoryInterface;
use App\HolidayManager\HolidayTime\HolidayExpenditureRepository;
use App\HolidayManager\HolidayTime\HolidayExpenditureRepositoryInterface;
use App\HolidayManager\HolidayTime\HolidayTimeCalculator;

class HomeController extends Controller
{

  /**
    @var \App\HolidayManager\HolidayTime\HolidayAllowanceRepositoryInterface Should be an object compatible
  */
  private $holidayAllowanceRepository;

  /**
    @var \App\HolidayManager\HolidayTime\HolidayExpenditureRepositoryInterface Should be an object compatible
  */
  private $holidayExpenditureRepository;

  /**
    Creates a new instance
  */
  public function __construct(HolidayAllowanceRepositoryInterface $holidayAllowanceRepository,HolidayExpenditureRepositoryInterface $holidayExpenditureRepository) {
    $this -> middleware('auth');
    $this -> holidayAllowanceRepository = $holidayAllowanceRepository;
    $this -> holidayExpenditureRepository = $holidayExpenditureRepository;
  }

  /**
    Processes the initial request for the homepage

    @TODO Write tests for the below
    @TODO Take action when no allowance is available

    @param \Illuminate\Http\Request $request
    @return \Illuminate\Http\Response
  */
  public function index(Request $request) {
    $user = Auth::user();
    $allowance = $this -> holidayAllowanceRepository -> getByUserId($user -> id);
    if($allowance) {//The user may not have any allowances
      $expenditures = $this -> holidayExpenditureRepository -> getByAllowanceId($allowance -> id);
      $holidayTimeCalculator = new HolidayTimeCalculator($allowance);
      $daysRemaining = $holidayTimeCalculator -> calculateRemainingDays($expenditures);
      return view('home',[
        'userName' => $user -> name,
        'daysRemaining' => $daysRemaining
      ]);
    } else {
      //There is no allowance for the user???
    }
  }

}
