<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HolidayAllowance extends Model
{

  /**
    Gets the activate HolidayAllowance for the user ID provided

    @param int $id The ID of the user
    @return HolidayAllowance The current holiday allowance for the user
  */
  public static function getForUserId($id) {
    $currentDate = date('Y-m-d H:i:s');
    return self::query()
      -> where('user_id','=',$id)
      -> where('starts','<=',$currentDate)
      -> where('expires','>',$currentDate)
      -> orderBy('id','desc')
      -> limit(1)
      -> first();
  }

  /**
    Gets the number of holiday days remaining based on the allowance

    @return Float The number of days remaining
  */
  public function daysRemaining() {
    $totalDays = $this -> days;
    $usedDays = $this -> used_days;
    return ($totalDays - $usedDays);
  }

}
