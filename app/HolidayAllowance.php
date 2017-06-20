<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HolidayAllowance extends Model
{

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

  public function daysRemaining() {
    $totalDays = $this -> days;
    $usedDays = $this -> used_days;
    return ($totalDays - $usedDays);
  }

}
