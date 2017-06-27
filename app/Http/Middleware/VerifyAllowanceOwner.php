<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

use App\HolidayManager\HolidayTime\HolidayAllowanceRepositoryInterface;

class VerifyAllowanceOwner
{

    private $holidayAllowanceRepository;

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
          return redirect('/home');
        }
        return $next($request);
    }
}
