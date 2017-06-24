<?php
namespace App\HolidayManager\HolidayTime;

use Illuminate\Database\Eloquent\Builder;

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
    $query = HolidayAllowance::query();
    $this -> scopeQuery($query);
    $allowance = $query
      -> where('user_id','=',$id)
      -> orderBy('id','desc')
      -> limit(1);
      return $allowance -> first();
  }

  /**
    Standardises a method to follow basic rules

    @param \Illuminate\Database\Eloquent\Builder $query The query to scope
    @param Array $ruleExclusions A list of rules that should not be applied
    to this instance of the query builder - Optional

    @return \Illuminate\Support\Facades\DB
  */
  private function scopeQuery(Builder &$query, $ruleExclusions=[]) {
    $currentDate = Carbon::now() -> toDateTimeString();
    if(!isset($ruleExclusions['starts'])) {
      $query -> where('starts','<=',$currentDate);
    }
    if(!isset($ruleExclusions['ends'])) {
      $query -> where('ends','>',$currentDate);
    }
  }

}
