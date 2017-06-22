<?php
namespace App\HolidayManager\HolidayTime;

use App\HolidayManager\HolidayTime\HolidayAllowanceRepositoryInterface;

class HolidayAllowanceRepository implements HolidayAllowanceRepositoryInterface{
  /**
    Gets a new HolidayAllowanceRepository

    @param Integer $id The ID of the user to check for

    @return \App\HolidayManager\HolidayTime\HolidayAllowance The allowance for
    the user
  */
  public function getByUserId($id) {
    $currentDate = date('Y-m-d H:i:s');
    $allowance = HolidayAllowance::query()
      -> where('user_id','=',$id)
      -> where('starts','<=',$currentDate)
      -> where('ends','>',$currentDate)
      -> orderBy('id','desc')
      -> limit(1);
      return $allowance -> first();
  }

}
