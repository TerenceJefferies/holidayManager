<?php

namespace App\HolidayManager\HolidayTime;

use Illuminate\Database\Eloquent\Model;
use App\HolidayManager\HolidayTime\HolidayExpenditureInterface;

class HolidayExpenditure extends Model implements HolidayExpenditureInterface
{

  /**
    @var Array The statuc code storage names mapped to their friendly names
  */
  private $statusCodes = array(
    'approved' => 'Approved',
    'pending' => 'Pending',
    'rejected' => 'Rejected'
  );

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

  /**
    Gets the friendly name for a status code from the storage name

    @return String The resultant friendly name
  */
  public function getStatusCodeName() {
    return $this -> statusCodes[$this -> status];
  }
}
