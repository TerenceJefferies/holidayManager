<?php
namespace App\HolidayManager\HolidayTime;

use App\HolidayManager\HolidayTime\HolidayExpenditureRepositoryInterface;

class HolidayExpenditureRepository implements HolidayExpenditureRepositoryInterface{

  /**
    Returns an appropriate set of objects based on the allowance ID provided

    @param Integer $id The ID of the allowance to use

    @return Collection The collection of expenditures associated with the
    allowance ID provided
  */
  public function getByAllowanceId($id) {
      $expenditures = HolidayExpenditure::query()
      -> where('allowance_id','=',$id)
      -> get();
      return $expenditures;
  }

}
