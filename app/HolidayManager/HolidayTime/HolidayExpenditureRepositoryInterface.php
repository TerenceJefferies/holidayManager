<?php
namespace App\HolidayManager\HolidayTime;

interface HolidayExpenditureRepositoryInterface{
  public function getByAllowanceId($id);
  public function getExpendituresForAllowance(HolidayAllowanceInterface $holidayAllowance,Bool $showUnapproved=true,Int $limit=0);
  public function getNextExpenditureForAllowance(HolidayAllowanceInterface $holidayAllowance,$showUnapproved=false);
  public function getExpendituresForAllowanceByStatus(HolidayAllowanceInterface $holidayAllowance,$status);
}
