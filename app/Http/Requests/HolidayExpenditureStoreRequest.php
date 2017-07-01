<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

use App\HolidayManager\HolidayTime\HolidayAllowanceRepositoryInterface;
use App\HolidayManager\HolidayTime\HolidayExpenditureRepositoryInterface;
use App\HolidayManager\HolidayTime\HolidayTimeCalculator;

class HolidayExpenditureStoreRequest extends FormRequest
{

    /**
     * @var \App\HolidayManager\HolidayTime\HolidayAllowanceRepositoryInterface
     */
    private $holidayAllowanceRepository;

    /**
     * @var \App\HolidayManager\HolidayTime\HolidayExpenditureRepositoryInterface
     */
    private $holidayExpenditureRepository;

    public function __construct(HolidayAllowanceRepositoryInterface $holidayAllowanceRepository,HolidayExpenditureRepositoryInterface $holidayExpenditureRepository) {
        $this -> holidayAllowanceRepository = $holidayAllowanceRepository;
        $this -> holidayExpenditureRepository = $holidayExpenditureRepository;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = Auth::user();
        $allowance = $this -> holidayAllowanceRepository -> getByUserId($user -> id);
        $expenditures = $this -> holidayExpenditureRepository -> getExpendituresForAllowanceByStatus($allowance,['approved','pending']);
        $calculator = new HolidayTimeCalculator($allowance);
        $remainingDays = $calculator -> calculateRemainingDays($expenditures);
        return [
          'startDate' => 'required|date|before:endDate|after_or_equal:today|holidayExpenditureNotConflicting',
          'endDate' => 'required|date|after:today|after:startDate',
          'days' => 'required|min:1'
        ];
    }

    /**
     * Defines the messages to display when an error occures
     * @return Array
     */
    public function messages() {
      return [
        'days.max' => 'Insufficent holiday time remaining'
      ];
    }
}
