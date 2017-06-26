<?php
  namespace App\HolidayManager;

  use Illuminate\Support\ServiceProvider;

  class InterfaceServiceProvider extends ServiceProvider {

    /**
      Registers services

      @return void
    */
    public function register() {
      $this -> app -> bind(
        'App\HolidayManager\HolidayTime\HolidayAllowanceRepositoryInterface',
        'App\HolidayManager\HolidayTime\HolidayAllowanceRepository'
      );
      $this -> app -> bind(
        'App\HolidayManager\HolidayTime\HolidayExpenditureRepositoryInterface',
        'App\HolidayManager\HolidayTime\HolidayExpenditureRepository'
      );
      $this -> app -> bind(
        'App\HolidayManager\HolidayTime\HolidayAllowanceInterface',
        'App\HolidayManager\HolidayTime\HolidayAllowance'
      );
    }

  }
