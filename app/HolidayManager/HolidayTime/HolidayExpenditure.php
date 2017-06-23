<?php

namespace App\HolidayManager\HolidayTime;

use Illuminate\Database\Eloquent\Model;
use App\HolidayManager\HolidayTime\HolidayExpenditureInterface;

class HolidayExpenditure extends Model implements HolidayExpenditureInterface
{

  /**
    @var Array The attributes in this model that are dates
  */
  protected $dates = ['starts','ends'];

  /**
    Returns the number of days in this expenditure

    @return Integer the number of days in the expenditure
  */
  public function getDays() {
    return $this -> days;
  }
}
