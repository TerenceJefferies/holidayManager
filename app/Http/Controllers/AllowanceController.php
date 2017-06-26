<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\HolidayManager\HolidayTime\HolidayExpenditureRepository;
use App\HolidayManager\HolidayTime\HolidayExpenditureRepositoryInterface;
use App\HolidayManager\HolidayTime\HolidayAllowanceRepositoryInterface;
use App\HolidayManager\HolidayTime\HolidayTimeCalculator;
use App\HolidayManager\HolidayTime\HolidayAllowanceInterface;

class AllowanceController extends Controller
{

    /**
      @var \App\HolidayManager\HolidayTime\HolidayAllowanceRepositoryInterface
      Should contain an instance of the HolidayAllowanceRepository
    */
    private $holidayAllowanceRepository;

    /**
      @var \App\HolidayManager\HolidayTime\HolidayExpenditureRepositoryInterface
      Should contain an object compatible with the
      HolidayExpenditureRepositoryInterface
    */
    private $holidayExpenditureRepository;

    /**
      Bootstrap method for controller

      @return void
    */
    public function __construct(HolidayAllowanceRepositoryInterface $holidayAllowanceRepository, HolidayExpenditureRepositoryInterface $holidayExpenditureRepository) {
      $this -> middleware('auth');
      /** @TODO Middleware must belong to user */
      $this -> holidayAllowanceRepository = $holidayAllowanceRepository;
      $this -> holidayExpenditureRepository = $holidayExpenditureRepository;
      }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $allowance = $this -> holidayAllowanceRepository -> getByUserId($user -> id);
        $expenditures = $this -> holidayExpenditureRepository -> getExpendituresForAllowance($allowance);
        $calculator = new HolidayTimeCalculator($allowance);
        $daysUsed = $calculator -> calculateHolidayDaysUsed($expenditures);
        $acceptedRequests = $this -> holidayExpenditureRepository -> getExpendituresForAllowanceByStatus($allowance,'approved');
        $rejectedRequests = $this -> holidayExpenditureRepository -> getExpendituresForAllowanceByStatus($allowance,'rejected');
        if($allowance) {
          return view('allowance.index',[
            'allowance' => $allowance,
            'daysUsed' => $daysUsed,
            'acceptedRequestsCount' => $acceptedRequests -> count(),
            'rejectedRequestsCount' => $rejectedRequests -> count()
          ]);
        } else {
          return redirect('/');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $allowance = $this -> holidayAllowanceRepository -> getById($id,true);
      $expenditures = $this -> holidayExpenditureRepository -> getExpendituresForAllowance($allowance);
      return view('allowance.show',[
        'allowance' => $allowance,
        'expenditures' => $expenditures
      ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
