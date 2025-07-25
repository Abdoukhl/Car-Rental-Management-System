@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Notifications</h1>
    
    <div class="list-group">
        @foreach($notifications as $notification)
        <div class="list-group-item {{ $notification->status === 'unread' ? 'unread-notification' : '' }}">
            <div class="d-flex justify-content-between">
                <p>{{ $notification->message }}</p>
                <small>{{ $notification->created_at->diffForHumans() }}</small>
            </div>
            @if($notification->type === 'booking_approved')
                <a href="{{ route('customer.bookings.show', $notification->related_id) }}" class="btn btn-sm btn-success">View Booking</a>
            @endif
        </div>
        @endforeach
    </div>
</div>

<style>
    .unread-notification {
        background-color: #f8f9fa;
        font-weight: bold;
    }
</style>
@endsection