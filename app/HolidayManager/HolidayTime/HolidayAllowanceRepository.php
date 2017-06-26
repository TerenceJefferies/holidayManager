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
    Gets an allowance by its ID

    @param Int $id The ID to get
    @param Boolean $ignoreRules If set to true, the exclusion rules will be
    applied

    @return \App\HolidayManager\HolidayTime\HolidayAllowance The allowance
    found
  */
  public function getById($id,$ignoreRules=false) {
    $ruleExclusions = ($ignoreRules) ? ['starts','ends'] : [];
    $query = HolidayAllowance::query();
    $this -> scopeQuery($query, $ruleExclusions);
    $allowance = $query
      -> where('id','=',$id)
      -> first();
    return $allowance;
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
    if(!in_array('starts',$ruleExclusions)) {
      $query -> where('starts','<=',$currentDate);
    }
    if(!in_array('ends',$ruleExclusions)) {
      $query -> where('ends','>',$currentDate);
    }
  }

}
