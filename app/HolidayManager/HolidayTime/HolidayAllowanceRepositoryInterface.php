<?php
namespace App\HolidayManager\HolidayTime;

interface HolidayAllowanceRepositoryInterface{
  public function getByUserId($id);
  public function getById($id,$ignoreRules=false);
}
