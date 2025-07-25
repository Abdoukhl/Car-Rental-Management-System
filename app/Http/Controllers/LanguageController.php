<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class LanguageController extends Controller
{
    // في Controller مثل LanguageController
    public function switchLang($locale)
    {
        if (!in_array($locale, ['en', 'ar'])) {
            abort(400);
        }
    
        // تخزين اللغة في الجلسة وتطبيقها فوراً
        session()->put('locale', $locale);
        app()->setLocale($locale); // ← هذه الخطوة حاسمة!
    
        return redirect()->back();
    }
}
