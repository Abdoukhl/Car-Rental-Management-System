<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\EnsureAdminEmail;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\{
    CarController, 
    AgencyController, 
    BookingController,
    FeedbackController,
    AdminController,
    MessageController,
    ProfileController,
    AgencyBookingController,
    ChatController,
    AgencyNotificationController
};



// routes/web.php
Route::view('/chat', 'chat');
Route::post('/chat', [\App\Http\Controllers\ChatController::class, 'respond']);


Route::prefix('features')->name('features.')->group(function () {
    Route::view('vehicle-variety', 'features.vehicle-variety')->name('vehicle-variety');
    Route::view('family-friendly', 'features.family-friendly')->name('family-friendly');
    Route::view('support', 'features.support')->name('support');
    Route::view('insurance', 'features.insurance')->name('insurance');
    Route::view('flexible-payment', 'features.flexible-payment')->name('flexible-payment');
    Route::view('trusted', 'features.trusted')->name('trusted');
});


// الصفحة الرئيسية
Route::get('/', function () {
    return view('guest');
})->name('guest');

// الصفحات الأساسية
Route::view('dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');
Route::view('profile', 'profile')->middleware(['auth'])->name('profile');

// صفحة الوكالة الرئيسية
Route::get('/Aghome', function () {
    return view('agency.Aghome', ['userType' => Auth::check() ? Auth::user()->role : null]);
})->name('agency.Aghome');

// مسارات إدارة السيارات للوكالة
Route::middleware(['auth'])->group(function () {
    Route::get('agency/add-car', [AgencyController::class, 'addCar'])->name('agency.addCar');
    Route::get('/agency/dashboard', [AgencyController::class, 'dashboard'])->name('agency.dashboard');
    Route::resource('car', CarController::class);
});

// routes/web.php
Route::get('lang/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'ar'])) {
        abort(400);
    }

    session(['locale' => $locale]);
    app()->setLocale($locale);

    return redirect()->back();
});





Route::middleware('auth')->group(function () {
    Route::post('/profile/update-photo', [ProfileController::class, 'updatePhoto'])->name('profile.update-photo');
});
// عرض قائمة السيارات للزبون
Route::get('/customer/carlist', [CarController::class, 'carList'])->name('customer.carlist');

// صفحة الاتصال
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// تسجيل الخروج
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');
// مسارات الحجز للزبائن
Route::middleware(['auth'])->group(function () {

    Route::get('/customer/bookings', [BookingController::class, 'index'])->name('customer.bookings');
    // إنشاء حجز جديد
    Route::get('/cars/{car}/book', [BookingController::class, 'create'])->name('bookings.create');
  
Route::post('/cars/{car}/bookings', [BookingController::class, 'store'])
->name('bookings.store')
->middleware('auth');
    
    // عرض الحجوزات
  

    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{booking}/status', [BookingController::class, 'status'])->name('bookings.status');
    Route::get('/bookings/{booking}/delivery', [BookingController::class, 'showDeliveryOptions'])
    ->middleware('auth')
    ->name('bookings.delivery-options');

// مسار لمعالجة اختيار طريقة الاستلام
Route::post('/bookings/{booking}/select-delivery', [BookingController::class, 'selectDeliveryMethod'])
    ->middleware('auth')
    ->name('bookings.select-delivery');

    
Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])
->middleware('auth')
->name('bookings.cancel');
    // متابعة الدفع
    Route::prefix('agency')->middleware(['auth'])->group(function () {
    // ... other routes ...
    Route::get('/bookings/{booking}', [AgencyBookingController::class, 'show'])->name('agency.bookings.show');
});

Route::get('/bookings/{booking}/payment/success', [BookingController::class, 'paymentSuccess'])
->name('booking.payment.success')
->middleware('auth');

Route::post('/bookings/{booking}/approve', [BookingController::class, 'approve'])->name('bookings.approve');
Route::post('/bookings/{booking}/reject', [BookingController::class, 'reject'])->name('bookings.reject');
Route::get('/bookings/{booking}/payment/failure', [BookingController::class, 'paymentFailure'])
->name('booking.payment.failure')
->middleware('auth');
Route::middleware(['auth'])->group(function () {
     // مسار عملية الدفع
     Route::get('/bookings/{booking}/payment', [BookingController::class, 'showPaymentPage'])
     ->name('bookings.payment');
    // Customer Bookings
    Route::get('/my-bookings', [BookingController::class, 'customerBookings'])
         ->name('bookings.customer-index');
         
    Route::get('/my-bookings/{booking}', [BookingController::class, 'showCustomerBooking'])
         ->name('bookings.customer-show');
});
    // تأكيد الحجز وإرسال الإشعار للوكالة + توجيه الزبون إلى الدفع
    Route::post('/bookings/{booking}/confirm', [BookingController::class, 'confirm'])
        ->name('bookings.confirm');

        Route::post('/bookings/{booking}/update-phone', [BookingController::class, 'updatePhone'])
    ->middleware('auth')
    ->name('bookings.update-phone');
    // تحديث طريقة الاستلام
    Route::post('/bookings/{booking}/update-delivery', [BookingController::class, 'updateDeliveryMethod'])
        ->name('bookings.updateDelivery');
});
Route::put('/bookings/{booking}/update-delivery', [BookingController::class, 'updateDelivery'])
    ->name('bookings.update-delivery')
    ->middleware('auth');
// مسارات الحجز للوكالة
Route::prefix('agency')->middleware(['auth'])->group(function() {
    Route::get('/bookings', [AgencyController::class, 'bookings'])->name('agency.bookings');
    Route::post('/bookings/{booking}/approve', [AgencyController::class, 'approveBooking'])
        ->name('agency.bookings.approve');
        Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::post('/bookings/{booking}/reject', [AgencyController::class, 'rejectBooking'])
        ->name('agency.bookings.reject');
    Route::post('/bookings/{booking}/update-delivery', [AgencyController::class, 'updateDeliveryMethod'])
        ->name('agency.bookings.update-delivery');
});

// Webhook لـ Chargily
Route::post('/webhook/chargily', [BookingController::class, 'handleChargilyWebhook'])
    ->name('webhook.chargily');


    Route::post('/cars/rate', [CarController::class, 'rate'])
    ->middleware('auth')
    ->name('car.rate');
// بقية المسارات كما هي...
Route::get('/check-document', [DocumentController::class, 'checkDocument']);

// مسارات الدفع
Route::get('/cars/{car}/payment', [CarController::class, 'payment'])->name('cars.payment');
Route::post('/cars/{car}/process-payment', [CarController::class, 'processPayment'])->name('cars.processPayment');

// مسارات الاشتراك
Route::middleware(['auth'])->group(function () {
    Route::get('/subscription/expired', [AgencyController::class, 'subscriptionExpired'])->name('subscription.expired');
    Route::get('/subscription/status', [AgencyController::class, 'subscriptionStatus'])->name('subscription.status');
    Route::get('/subscription/renew', [AgencyController::class, 'showRenewSubscription'])->name('subscription.renew');
    Route::post('/subscription/renew', [AgencyController::class, 'renewSubscription'])->name('subscription.renew.post');
    Route::get('/subscription/success', [AgencyController::class, 'subscriptionSuccess'])->name('subscription.success');
    Route::get('/subscription/fail', [AgencyController::class, 'subscriptionFail'])->name('subscription.fail');
});

// روابط التقييمات
Route::middleware(['auth'])->group(function () {
    Route::get('/cars/{car_id}/feedback/create', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/cars/{car_id}/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
    Route::get('/cars/{car_id}/feedback', [FeedbackController::class, 'show'])->name('feedback.show');
    Route::post('/cars/rate', [CarController::class, 'rate'])->name('car.rate');
});

// مسارات الأدمن
Route::middleware('auth')->group(function () {
    // لوحة تحكم الأدمن
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // إدارة الوكالات
    Route::get('/admin/agencies', [AdminController::class, 'manageAgencies'])->name('admin.agencies.index');
    Route::get('/admin/agencies/{id}', [AdminController::class, 'showAgency'])->name('admin.agencies.show');
    Route::get('/admin/agencies/{id}/edit', [AdminController::class, 'editAgency'])->name('admin.agencies.edit');
    Route::put('/admin/agencies/{id}', [AdminController::class, 'updateAgency'])->name('admin.agencies.update');
    Route::delete('/admin/agencies/{id}', [AdminController::class, 'destroyAgency'])->name('admin.agencies.destroy');

    // تفعيل حساب الوكالة
    Route::post('/admin/agencies/activate/{id}', [AdminController::class, 'activateAgency'])->name('admin.agencies.activate');

    // عرض الوكالات غير المفعلة
    Route::get('/admin/agencies/pending', [AdminController::class, 'pendingAgencies'])->name('admin.agencies.pending');

    // إدارة الإشعارات
    Route::get('/admin/notifications', [AdminController::class, 'manageNotifications'])->name('admin.notifications.index');
    Route::get('/admin/notifications/{id}', [AdminController::class, 'showNotification'])->name('admin.notifications.show');
    Route::delete('/admin/notifications/{id}', [AdminController::class, 'destroyNotification'])->name('admin.notifications.destroy');

    // تحديد الإشعار كمقروء
    Route::post('/admin/notification/markAsRead/{id}', [AdminController::class, 'markAsRead'])->name('admin.notification.markAsRead');

    // قبول طلب اشتراك
    Route::post('/admin/subscription/approve/{id}', [AdminController::class, 'approveSubscription'])->name('admin.subscription.approve');

    // رفض طلب اشتراك
    Route::post('/admin/subscription/reject/{id}', [AdminController::class, 'rejectSubscription'])->name('admin.subscription.reject');
});

// Webhook لـ Chargily
Route::post('/webhook/chargily', [AgencyController::class, 'handleChargilyWebhook']);


Route::prefix('admin')->group(function () {
    Route::get('/documents', [DocumentController::class, 'index'])->name('admin.agencies.documents');
    Route::post('/admin/documents/{id}/approve', [AdminController::class, 'approveDocument'])->name('admin.documents.approve');
 // إضافة مسارات إدارة المستخدمين
 Route::get('/users', [AdminController::class, 'manageUsers'])->name('admin.users.index');
 Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

    Route::post('/admin/documents/{id}/reject', [AdminController::class, 'rejectDocument'])->name('admin.documents.reject');
});
Route::prefix('agency')->group(function () {
    Route::get('/{agencyId}/notifications', [AgencyNotificationController::class, 'index'])->name('agency.notifications');
    Route::post('/notifications/{notificationId}/mark-as-read', [AgencyNotificationController::class, 'markAsRead'])->name('agency.notifications.markAsRead');
});

Route::post('/agency/notifications/clear-history', [AgencyNotificationController::class, 'clearHistory'])
    ->name('agency.notifications.clearHistory');
    
Route::get('/agency/notifications', [AgencyNotificationController::class, 'index'])
    ->name('agency.notifications');
    Route::post('/agency/notifications/mark-all-as-read', [AgencyNotificationController::class, 'markAllAsRead'])
    ->name('agency.notifications.markAllAsRead');
   

    Route::get('/agency/reupload-document/{id}', [AgencyController::class, 'showReuploadForm'])->name('agency.reuploadDocument');
   

    Route::prefix('admin')->middleware(['auth'])->group(function () {
        // ... روoutes أخرى موجودة
        
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class)
             ->names([
                 'index' => 'admin.users.index',
                 'destroy' => 'admin.users.destroy'
             ]);
    });
    Route::prefix('admin')->middleware(['auth'])->group(function () {
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->names('admin.users');
    });
    
// للمستخدم العادي
Route::middleware(['auth'])->group(function () {
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::resource('messages', MessageController::class)->except(['create', 'edit']);
  
});
Route::get('/my-bookings/{booking}', [BookingController::class, 'showCustomerBooking'])
    ->name('bookings.customer-show')
    ->middleware('auth');
// للإدمن
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::delete('messages/destroy-all', [MessageController::class, 'destroyAll'])->name('admin.messages.destroyAll');
    Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('admin.messages.destroy');
    Route::get('/messages', [MessageController::class, 'index'])->name('admin.messages.index');
    Route::put('/messages/{message}', [MessageController::class, 'update'])->name('messages.update');
    Route::post('/profile/update-photo', [ProfileController::class, 'updatePhoto'])->name('profile.update-photo');
    Route::put('/messages/{message}/read', [MessageController::class, 'update'])->name('admin.messages.update');
});
    
    Route::post('/agency/reupload-document/{id}', [AgencyController::class, 'reuploadDocument'])->name('agency.reuploadDocument');
 
   Route::post('/agency/reupload-document', [AgencyController::class, 'reuploadDocument'])->name('agency.reuploadDocument');




// هذه الروابط ستكون خاصة بالمسؤول فقط
Route::middleware(['auth'])->group(function () {
    // عرض البروفايل
    Route::get('/admin/profile', [AdminController::class, 'showProfile'])->name('admin.profile');
    
    // صفحة تعديل البروفايل
    Route::get('/admin/profile/edit', [AdminController::class, 'editProfile'])->name('admin.profile.edit');
    
    // عملية حفظ التعديلات
    Route::put('/admin/profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
});


   // تحميل مسارات المصادقة

require __DIR__.'/auth.php';