<?php
namespace App\HolidayManager\HolidayTime;

interface HolidayAllowanceRepositoryInterface{
  public function getByUserId($id);
}
