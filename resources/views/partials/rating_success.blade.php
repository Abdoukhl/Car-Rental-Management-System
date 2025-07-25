<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>
    <strong>Thank you!</strong> Your rating has been saved successfully.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<div class="rating-result mt-3">
    <div class="stars">
        @for($i = 1; $i <= 5; $i++)
            <i class="fas fa-star {{ $i <= $average_rating ? 'text-warning' : 'text-secondary' }}"></i>
        @endfor
    </div>
    <p class="text-muted mt-2">
        Average rating: {{ number_format($average_rating, 1) }} ({{ $ratings_count }} ratings)
    </p>
</div>