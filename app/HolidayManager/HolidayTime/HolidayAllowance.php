<?php

namespace App\HolidayManager\HolidayTime;

use Illuminate\Database\Eloquent\Model;
use App\HolidayManager\HolidayTime\HolidayAllowanceInterface;

class HolidayAllowance extends Model implements HolidayAllowanceInterface
{
  /**
    Gets the number of days in this allowance and returns them

    @return Float The number of days in the allowance
  */
  public function getDays() {
    return $this -> days;
  }
}
