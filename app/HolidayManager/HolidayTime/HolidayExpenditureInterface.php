<?php
namespace App\HolidayManager\HolidayTime;

interface HolidayExpenditureInterface {
  public function getDays();
  public function getStatusCodeName();
}
