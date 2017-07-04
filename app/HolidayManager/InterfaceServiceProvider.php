<?php
  namespace App\HolidayManager;

  use Illuminate\Support\Facades\Auth;
  use Illuminate\Support\ServiceProvider;

  use App\HolidayManager\HolidayTime\HolidayAllowanceInterface;
  use App\HolidayManager\HolidayTime\HolidayAllowance;

  class InterfaceServiceProvider extends ServiceProvider {

    protected $defer = true;

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
