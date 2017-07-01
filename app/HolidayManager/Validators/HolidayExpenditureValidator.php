<?php
  namespace App\HolidayManager\Validators;

  use Illuminate\Support\Facades\Auth;

  use App\HolidayManager\HolidayTime\HolidayAllowanceRepositoryInterface;
  use App\HolidayManager\HolidayTime\HolidayExpenditureRepositoryInterface;

  use Carbon\Carbon;

  class HolidayExpenditureValidator{

    private $holidayAllowanceRepository;
    private $holidayExpenditureRepository;

    /**
     * Startup method
     * @param HolidayAllowanceRepositoryInterface   $holidayAllowanceInterface
     * @param HolidayExpenditureRepositoryInterface $holidayExpenditureRepository
     */
    public function __construct(HolidayAllowanceRepositoryInterface $holidayAllowanceRepository, HolidayExpenditureRepositoryInterface $holidayExpenditureRepository)
    {
      $this -> holidayAllowanceRepository = $holidayAllowanceRepository;
      $this -> holidayExpenditureRepository = $holidayExpenditureRepository;
    }

    /**
     * Ensures that a expenditure request does not conflict with a pre-existing
     * one
     *
     * @TODO Look for a nicer solution - This solution ignores any parameters
     * passed and simply gets them from the request.
     *
     * @param String $attribute The attribute name being verified
     * @param  String $value    The value of the attribute
     * @return Boolean  True if they do not collide, false otherwise
     */
    public function notConflicting($attribute,$value)
    {
      $startDate = Carbon::createFromFormat('Y-m-d',request() -> startDate);
      $endDate = Carbon::createFromFormat('Y-m-d',request() -> endDate);
      $user = Auth::user();
      $allowance = $this -> holidayAllowanceRepository -> getByUserId($user -> id);
      if($allowance) {
        $conflictingExpenditure = $this -> holidayExpenditureRepository -> getByPeriod($allowance,$startDate,$endDate);
        if(!$conflictingExpenditure) {
          return true;
        }
        return false;
      } else {
        return false;
      }
    }

  }
