<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSubscription
{
    public function handle(Request $request, Closure $next)
    {
        $agency = Auth::user()->agency;

        if (!$agency || !$agency->subscription || $agency->subscription->end_date < now()) {
            return redirect()->route('subscription.expired')->with('error', 'Your subscription has expired.');
        }

        return $next($request);
    }
}