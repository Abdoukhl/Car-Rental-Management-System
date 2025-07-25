<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Models\Booking;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */

     public function boot()
     { // تعيين اللغة من الجلسة
        $locale = session('locale', config('app.locale')); // إذا لم تكن موجودة في الجلسة، استخدم اللغة الافتراضية
        App::setLocale($locale);
         // ربط مكون Blade
         Blade::component('layouts.app', 'app-layout');
     
         // ✅ تنفيذ الحذف التلقائي مرة واحدة يوميًا
         if (!Cache::has('daily_booking_cleanup')) {
             $deleted = Booking::whereDate('end_date', '<=', Carbon::today())->delete();
     
             Cache::put('daily_booking_cleanup', true, 1440); // لمدة 24 ساعة
     
             Log::info("✅ تم حذف $deleted حجوزات منتهية تلقائيًا.");
         }
          
        }
}
