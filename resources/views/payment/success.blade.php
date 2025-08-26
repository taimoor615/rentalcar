<x-app-layout>
    {{-- {{ dd($booking->car) }} --}}
    @section('title', 'Payment Successful')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card text-center shadow-sm">
                    <div class="card-body p-5">
                        <!-- Success Icon -->
                        <div class="mb-4">
                            <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <svg width="40" height="40" fill="white" viewBox="0 0 16 16">
                                    <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                </svg>
                            </div>
                        </div>

                        <!-- Heading -->
                        <h2 class="text-success mb-3">Payment Successful!</h2>
                        <p class="mb-4">Your car booking has been confirmed. A confirmation email will be sent to you shortly.</p>

                        <!-- Car Details -->
                        <div class="card bg-light mb-4">
                            <div class="card-body text-start">
                                <h5 class="mb-2">{{ $booking->car->title }} </h5>
                                <p class="text-muted mb-2">
                                    {{ $booking->car->location }}
                                </p>

                                @if($booking->car->getFirstMediaUrl('images'))
                                    <div class="mb-3 text-center">
                                        <img src="{{ $booking->car->getFirstMediaUrl('images', 'thumb') }}"
                                             alt="{{ $booking->car->make }} {{ $booking->car->model }}"
                                             class="img-fluid rounded" style="max-height: 200px;">
                                    </div>
                                @endif

                                <p><strong>Rental Dates:</strong> {{ $booking->start_date->format('M d, Y') }} - {{ $booking->end_date->format('M d, Y') }}</p>
                                <p><strong>Total Paid:</strong> ${{ number_format($booking->total_price, 2) }}</p>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-grid gap-2">
                            <a href="{{ route('bookings.show', $booking) }}" class="btn btn-primary">View Booking Details</a>
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Go to Dashboard</a>
                            <a href="{{ route('listings.index') }}" class="btn btn-outline-primary">Browse More Cars</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
