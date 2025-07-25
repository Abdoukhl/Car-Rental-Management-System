<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class SetLocale
{
  
 // app/Http/Middleware/SetLocale.php
// app/Http/Middleware/SetLocale.php
public function handle($request, Closure $next)
{
    // تأكد من بدء الجلسة أولاً
    if (!session()->isStarted()) {
        session()->start();
    }

    // الأولوية: لغة الجلسة > لغة الكونفيج الافتراضية
    $locale = session('locale', config('app.locale'));
    app()->setLocale($locale);

    return $next($request);
}
}
?>