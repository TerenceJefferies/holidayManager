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

    @return Float The number of remaining days

  */
  public function calculateRemainingDays(\Traversable $expenditures) {
    $totalDays = $this -> allowance -> getDays();
    foreach($expenditures as $expenditure) {
      if($expenditure -> status != 'rejected') {
        $daysUsed = $expenditure -> getDays();
        $totalDays -= $daysUsed;
      }
    }
    return $totalDays;
  }

  /**
    Calculates the total number of days used from the provided expenditures

    @param \Traversable A list of expenditures that should be summed

    @return Float The total number of days used
  */
  public static function calculateHolidayDaysUsed(\Traversable $expenditures) {
    $daysUsed = 0;
    foreach($expenditures as $expenditure) {
      if($expenditure -> status != 'rejected') {
        $daysUsed += $expenditure -> getDays();
      }
    }
    return $daysUsed;
  }

}
