<?php
namespace App\HolidayManager\HolidayTime;

use Illuminate\Database\Eloquent\Builder;

use App\HolidayManager\HolidayTime\HolidayExpenditureRepositoryInterface;
Use Carbon\Carbon;

class HolidayExpenditureRepository implements HolidayExpenditureRepositoryInterface{

  /**
    Gets expenditures by the status or multiple status operators provided

    @param \App\HolidayManager\HolidayTime\HolidayAllowanceInterface
    $holidayAllowance The allowance to get the expenditures for
    @param Mixed $status Either a string with the single status being searched
    for, or an array of statuses being searched for
    @param Integer $limit The maximum number of results that should be
    returned
    @param String $orderField The field to order the results on
    @param String $orderDirection The direction to order the results field on

    @return Collection The reults - Null if nothing available
  */
  public function getExpendituresForAllowanceByStatus(HolidayAllowanceInterface $holidayAllowance,$status,Int $limit=0,$orderField='created_at',$orderDirection='desc') {
    $query = $holidayAllowance -> hasMany('App\HolidayManager\HolidayTime\HolidayExpenditure','allowance_id') -> getQuery();
    $this -> scopeQuery($query);
    if($status) {
      if(is_array($status)) {
        $query -> where(function($query) use ($status) {
          $count = 0;
          foreach($status as $statusEntry) {
            $query -> orWhere('status','=',$statusEntry);
            $count ++;
          }
        });
      } else if(is_string($status)) {
        $query -> where('status','=',$status);
      }
    }
    if($orderField) {
      $commitOrderDirection = ($orderDirection) ? $orderDirection : 'asc';
      $query -> orderBy($orderField,$orderDirection);
    }
    if($limit > 0) {
      $query -> limit($limit);
    }
    return $query -> get();
  }
  /**
    Gets the expenditures associated with an allowance

    @param \App\HolidayManager\HolidayTime\HolidayAllowanceInterface
    $holidayAllowance The allowance to get the expenditures for
    @param Boolean $showUnapproved If set to true unapproved expenditures will
    be returned, optional, true by default
    @param Integer $limit The maximum number of results to return
    @param String $orderField The field to order the results on
    @param String $orderDirection The direction to order the results field on

    @return Collection The associated expenditures
  */
  public function getExpendituresForAllowance(HolidayAllowanceInterface $holidayAllowance,Bool $showUnapproved=true,Int $limit=0,$orderField='created_at',$orderDirection='desc') {
    $restrictions = null;
    if(!$showUnapproved) {
      $restrictions = ['approved'];
    }
    $result = $this -> getExpendituresForAllowanceByStatus($holidayAllowance,$restrictions,$limit,$orderField,$orderDirection);
    return $result;
  }

  /**
    Gets the next expenditure for this holiday allowance for the user, closest
    to the current date

    @param \App\HolidayManager\HolidayTime\HolidayAllowanceInterface
    $holidayAllowance The allowance to get the next expenditure for
    @param Boolean $showUnapproved True if expenditures that have not been
    approved should be shown, false otherwise - Optional - Defaults to false

    @return \App\HolidayManager\HolidayTime\HolidayExpenditure The next
    expenditure associated with the allowance
  */
  public function getNextExpenditureForAllowance(HolidayAllowanceInterface $holidayAllowance,$showUnapproved=false) {
    $currentDate = Carbon::now() -> toDateTimeString();
    $query = $holidayAllowance -> hasMany('App\HolidayManager\HolidayTime\HolidayExpenditure','allowance_id') -> getQuery();
    $this -> scopeQuery($query);
    $query -> where('starts','>',$currentDate);
    if(!$showUnapproved) {
      $query -> where('status','=','approved');
    }
    $query -> orderBy('starts','asc')
      -> limit(1);
    return $query -> first();
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
   * Creates a new expenditure by it's allowance
   * @param  Integer $allowanceId The ID of the allowance to associated the
   * expenditure with
   * @param  Carbon $startDate   The start date of the expenditure
   * @param  Float $days        The number of days the expenditure goes on for
   *
   * @return App\HolidayManager\HolidayTime\HolidayExpenditureRepositoryInterface
   * The new expenditure that has been created
   */
  public function createByAllowanceId($allowanceId,Carbon $startDate,$days) {
    $endDate = clone $startDate;
    $daysRounded = floor($days);//We floor the value to ensure half days stay correct
    $endDate -> addDays($days);
    $expenditure = HolidayExpenditure::create([
        'allowance_id' => $allowanceId,
        'starts' => $startDate -> toDateString(),
        'ends' => $endDate -> toDateString(),
        'days' => $days,
        'status' => 'pending'
    ]);
    return $expenditure;
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
