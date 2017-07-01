<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Requests\HolidayExpenditureStoreRequest;

use App\HolidayManager\HolidayTime\HolidayExpenditureRepositoryInterface;
use App\HolidayManager\HolidayTime\HolidayAllowanceRepositoryInterface;
use App\HolidayManager\HolidayTime\HolidayTimeCalculator;
use Carbon\Carbon;

class ExpenditureController extends Controller
{

    /**
     * Repository for holiday expenditure objects
     * @var App\HolidayManager\HolidayTime\HolidayExpenditureRepositoryInterface
     */
    private $holidayExpenditureRepository;

    /**
     * Repository for holiday allowances
     * @var App\HolidayManager\HolidayTime\HolidayAllowanceRepositoryInterface
     */
    private $holidayAllowanceRepository;

    /**
     * Bootstrap method for setting up the Controller
     * @param \App\HolidayManager\HolidayTime\HolidayExpenditureRepositoryInterface
     * $holidayExpenditureRepository The repository to work with for this object
     * type
     */
    public function __construct(HolidayExpenditureRepositoryInterface $holidayExpenditureRepository,HolidayAllowanceRepositoryInterface $holidayAllowanceRepository) {
      $this -> holidayExpenditureRepository = $holidayExpenditureRepository;
      $this -> holidayAllowanceRepository = $holidayAllowanceRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('expenditure.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\HolidayManager\Requests\HolidayExpenditureStoreReuqest $request
     * @return \Illuminate\Http\Response
     */
    public function store(HolidayExpenditureStoreRequest $request)
    {
        $user = Auth::user();
        $allowance = $this -> holidayAllowanceRepository -> getByUserId($user -> id);
        $startDate = Carbon::createFromFormat('Y-m-d',$request -> startDate);
        $this -> holidayExpenditureRepository -> createByAllowanceId($allowance -> id,$startDate,$request -> days);
        $request -> session() -> flash('submission','Your request has been successfully created');
        return redirect() -> route('createExpenditure');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
