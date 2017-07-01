<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

use App\HolidayManager\HolidayTime\HolidayAllowanceRepositoryInterface;

class VerifyAllowanceOwner
{

    /**
     * Should contain a HolidayAllowanceRepositoryInterface compatible object
     *
     * @var \App\HolidayManager\HolidayTime\HolidayAllowanceRepositoryInterface
     * $holidayAllowanceRepository
     */
    private $holidayAllowanceRepository;

    /**
     * Bootstrap method for the VerifyAllowanceOwner class
     * @param \App\HolidayManager\HolidayTime\HolidayAllowanceRepositoryInterface $holidayAllowanceRepository
     * A compatible object to get necessary data from
     */
    public function __construct(HolidayAllowanceRepositoryInterface $holidayAllowanceRepository)
    {
      $this -> holidayAllowanceRepository = $holidayAllowanceRepository;
    }

    /**
     * Ensure that the requester of the current allowance actually owns it
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $targetAllowance = $this -> holidayAllowanceRepository -> getById($request -> id,true);
        if(Auth::user() -> id != $targetAllowance -> user_id) {
          return redirect() -> route('home');
        }
        return $next($request);
    }
}
