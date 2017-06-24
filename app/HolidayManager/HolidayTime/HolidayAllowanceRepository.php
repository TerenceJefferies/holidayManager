<?php
namespace App\HolidayManager\HolidayTime;

use App\HolidayManager\HolidayTime\HolidayAllowanceRepositoryInterface;
use Carbon\Carbon;

class HolidayAllowanceRepository implements HolidayAllowanceRepositoryInterface{
  /**
    Gets a new HolidayAllowanceRepository

    @param Integer $id The ID of the user to check for

    @return \App\HolidayManager\HolidayTime\HolidayAllowance The allowance for
    the user
  */
  public function getByUserId($id) {
    $allowance = $this -> getQueryBuilder()
      -> where('user_id','=',$id)
      -> orderBy('id','desc')
      -> limit(1);
      return $allowance -> first();
  }

  /**
    Standard query builder retriever for this repository, designed to allow
    for a standard set of rules to be updated in a single locale

    @param Array $ruleExclusions A list of rules that should not be applied
    to this instance of the query builder - Optional

    @return \Illuminate\Support\Facades\DB
  */
  private function getQueryBuilder($ruleExclusions=[]) {
    $currentDate = Carbon::now() -> toDateTimeString();
    $query = HolidayAllowance::query();
    if(!isset($ruleExclusions['starts'])) {
      $query -> where('starts','<=',$currentDate);
    }
    if(!isset($ruleExclusions['ends'])) {
      $query -> where('ends','>',$currentDate);
    }
    return $query;
  }

}
