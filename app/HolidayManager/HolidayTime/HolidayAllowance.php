<?php

namespace App\HolidayManager\HolidayTime;

use Illuminate\Database\Eloquent\Model;
use App\HolidayManager\HolidayTime\HolidayAllowanceInterface;

class HolidayAllowance extends Model implements HolidayAllowanceInterface
{

  /**
    @var Array Ther attributes in this model that are dates
  */
  protected $dates = ['starts','ends'];

  /**
    Gets the number of days in this allowance and returns them

    @return Float The number of days in the allowance
  */
  public function getDays() {
    return $this -> days;
  }

  /**
    Calculates the remaining days when the expenditures provided are compares to
    the allowance stored

    @param \Traversable A list of expenditures to used to calculate the number
    of remaining days

    @return Float The number of remaining days

  */
  public function calculateRemainingDays(\Traversable $expenditures) {
    $totalDays = $this -> getDays();
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
  public function calculateHolidayDaysUsed(\Traversable $expenditures) {
    $daysUsed = 0;
    foreach($expenditures as $expenditure) {
      if($expenditure -> status != 'rejected') {
        $daysUsed += $expenditure -> getDays();
      }
    }
    return $daysUsed;
  }

}
