<?php
namespace App\HolidayManager\HolidayTime;

use App\HolidayManager\HolidayTime\HolidayAllowanceInterface;

class HolidayTimeCalculator{

  private $allowance;

  /**
    Boot method for the calculator

    @param \App\HolidayManager\HolidayTime\HolidayAllowanceInterface The
    allowance object to use when comparing objects

    @return void
  */
  public function __construct(HolidayAllowanceInterface $allowance) {
    $this -> allowance = $allowance;
  }

  /**
    Calculates the remaining days when the expenditures provided are compares to
    the allowance stored

    @param \Traversable A list of expenditures to used to calculate the number
    of remaining days

    @return Integer The number of remaining days

  */
  public function calculateRemainingDays(\Traversable $expenditures) {
    $totalDays = $this -> allowance -> getDays();
    foreach($expenditures as $expenditure) {
      $daysUsed = $expenditure -> getDays();
      $totalDays -= $daysUsed;
    }
    return $totalDays;
  }

}
