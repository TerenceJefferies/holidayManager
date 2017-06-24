<?php
namespace App\HolidayManager\HolidayTime;

use Illuminate\Database\Eloquent\Builder;

use App\HolidayManager\HolidayTime\HolidayExpenditureRepositoryInterface;
Use Carbon\Carbon;

class HolidayExpenditureRepository implements HolidayExpenditureRepositoryInterface{

  /**
    Gets the expenditures associated with an allowance

    @param \App\HolidayManager\HolidayTime\HolidayAllowanceInterface
    $holidayAllowance The allowance to get the expenditures for

    @return Collection The associated expenditures
  */
  public function getExpendituresForAllowance(HolidayAllowanceInterface $holidayAllowance) {
    $query = $holidayAllowance -> hasMany('App\HolidayManager\HolidayTime\HolidayExpenditure','allowance_id') -> getQuery();
    $this -> scopeQuery($query);
    return $query -> get();
  }

  /**
    Gets the next expenditure for this holiday allowance for the user, closest
    to the current date

    @return \App\HolidayManager\HolidayTime\HolidayExpenditure The next
    expenditure associated with the allowance
  */
  public function getNextExpenditureForAllowance(HolidayAllowanceInterface $holidayAllowance) {
    $currentDate = Carbon::now() -> toDateTimeString();
    $query = $holidayAllowance -> hasMany('App\HolidayManager\HolidayTime\HolidayExpenditure','allowance_id') -> getQuery();
    $this -> scopeQuery($query);
    $result = $query -> where('starts','>',$currentDate)
      -> orderBy('starts','asc')
      -> limit(1)
      -> first();
      return $result;
  }

  /**
    Returns an appropriate set of objects based on the allowance ID provided

    @param Integer $id The ID of the allowance to use

    @return Collection The collection of expenditures associated with the
    allowance ID provided
  */
  public function getByAllowanceId($id) {
      $query = HolidayExpenditure::query();
      $this -> scopeQuery($query);
      $expenditures = $query
      -> where('allowance_id','=',$id)
      -> get();
      return $expenditures;
  }

  /**
    Scoping method to ensure the query made follows any applicable rules

    @param \Illuminate\Database\Eloquent\Builder The builder to scope - Pass
    by reference
    @param Array $ruleExclusions An array containing any rules that should not
    be applied to this get

    @return Void
  */
  private function scopeQuery(Builder &$query, $ruleExclusions=[]) {

  }

}
