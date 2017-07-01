<?php
namespace App\HolidayManager\HolidayTime;

use Carbon\Carbon;

interface HolidayExpenditureRepositoryInterface{
  public function getByAllowanceId($id);
  public function getExpendituresForAllowance(HolidayAllowanceInterface $holidayAllowance,Bool $showUnapproved=true,Int $limit=0,$orderField='created_at',$orderDirection='desc');
  public function getNextExpenditureForAllowance(HolidayAllowanceInterface $holidayAllowance,$showUnapproved=false);
  public function getExpendituresForAllowanceByStatus(HolidayAllowanceInterface $holidayAllowance,$status,Int $limit=0,$orderField='created_at',$orderDirection='desc');
  public function createByAllowanceId($allowanceId,Carbon $startDate,$days);
}
