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
      $expenditures = $this -> getQueryBuilder()
      -> where('allowance_id','=',$id)
      -> get();
      return $expenditures;
  }

  /**
    Central method for retrieving a query builder for interaction, allows
    global rules for appliability to be applied/removed in a central place

    @param Array $ruleExclusions An array containing any rules that should not
    be applied to this get

    @return \Illuminate\Support\Facades\DB
  */
  private function getQueryBuilder($ruleExclusions=[]) {
    return HolidayExpenditure::query();
  }

}
