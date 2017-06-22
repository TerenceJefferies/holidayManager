<?php
namespace App\HolidayManager\HolidayTime;

interface HolidayExpenditureRepositoryInterface{
  public function getByAllowanceId($id);
}
