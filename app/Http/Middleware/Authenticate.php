<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // التحقق من أن المستخدم مسجل الدخول
        if (!Auth::check()) {
            // إذا لم يكن المستخدم مسجل الدخول، قم بتوجيهه إلى صفحة تسجيل الدخول
            return redirect()->route('login');
        }

        // إذا كان المستخدم مسجل الدخول، قم بتمرير الطلب إلى الـ Middleware التالي
        return $next($request);
    }
}