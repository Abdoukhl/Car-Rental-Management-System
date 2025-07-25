@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h3 class="mb-0">فشل في عملية الدفع</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i> لم يتم تأكيد حجزك للسيارة {{ $booking->car->brand }} {{ $booking->car->model }}
                    </div>
                    <a href="{{ route('customer.carlist') }}" class="btn btn-primary">
                        العودة إلى قائمة السيارات
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection