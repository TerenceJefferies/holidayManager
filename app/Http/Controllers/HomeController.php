<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\HolidayAllowance;

class HomeController extends Controller
{

  /**
    Creates a new instance
  */
  public function __construct() {
    $this -> middleware('auth');
  }

  /**
    Processes the initial request for the homepage

    @param \Illuminate\Http\Request $request
    @return \Illuminate\Http\Response
  */
  public function index(Request $request) {
    $user = Auth::user();
    $allowance = HolidayAllowance::getForUserId($user -> id);
    $daysRemaining = $allowance -> daysRemaining();
    return view('home',[
      'holidayDaysRemaining' => $daysRemaining,
      'userName' => $user -> name
    ]);
  }

}
