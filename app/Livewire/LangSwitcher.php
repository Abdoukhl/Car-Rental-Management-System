<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LangSwitcher extends Component
{
    public function changeLang($locale)
    {
        if (!in_array($locale, ['en', 'ar'])) return;

        session()->put('locale', $locale);
        App::setLocale($locale); // ← مهم جدًا

        // أعد تحميل الصفحة لإجبار Laravel + Livewire على التقاط اللغة
        return redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.lang-switcher');
    }
}
