<?php
namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait AdminCheck
{
    protected function checkAdmin()
    {
        if (Auth::user()->account_type !== 'admin') {
            return redirect('/')->with('error', 'You do not have access to this section.');
        }
    }
}