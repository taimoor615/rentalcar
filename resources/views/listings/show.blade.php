<x-app-layout>
    @section('title', $listing->title)
    <div class="container my-4">
        <!-- Car Images -->
        <div class="row mb-4">
            <div class="col-12">
                @if($listing->getMedia('images')->count() > 0)
                    <div id="carCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($listing->getMedia('images') as $index => $media)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ $media->getUrl('large') }}" class="d-block w-100"
                                         style="height: 400px; object-fit: cover;" alt="{{ $listing->title }}">
                                </div>
                            @endforeach
                        </div>
                        @if($listing->getMedia('images')->count() > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#carCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        @endif
                    </div>
                @elseif($listing->images && is_array($listing->images) && count($listing->images) > 0)
                    <!-- Fallback to images array if media library is not used -->
                    <div id="carCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($listing->images as $index => $image)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ $image }}" class="d-block w-100"
                                         style="height: 400px; object-fit: cover;" alt="{{ $listing->title }}">
                                </div>
                            @endforeach
                        </div>
                        @if(count($listing->images) > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#carCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        @endif
                    </div>
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                        <span class="text-muted">No Images Available</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <h1>{{ $listing->title }}</h1>
                <p class="text-muted mb-3">{{ $listing->year }} {{ $listing->make }} {{ $listing->model }}</p>
                <p class="text-muted mb-3">📍 {{ $listing->location }}</p>

                <div class="d-flex gap-4 mb-4">
                    <span><strong>Year:</strong> {{ $listing->year }}</span>
                    <span><strong>Make:</strong> {{ $listing->make }}</span>
                    <span><strong>Model:</strong> {{ $listing->model }}</span>
                </div>

                <!-- Car Specifications -->
                @if($listing->specs && is_array($listing->specs) && count($listing->specs) > 0)
                    <div class="mb-4">
                        <h5>Car Specifications</h5>
                        <div class="row">
                            @if(isset($listing->specs['transmission']))
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-cogs me-2 text-primary"></i>
                                        <div>
                                            <strong>Transmission</strong><br>
                                            <span class="text-muted">{{ $listing->specs['transmission'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if(isset($listing->specs['fuel_type']))
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-gas-pump me-2 text-primary"></i>
                                        <div>
                                            <strong>Fuel Type</strong><br>
                                            <span class="text-muted">{{ $listing->specs['fuel_type'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if(isset($listing->specs['seats']))
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-users me-2 text-primary"></i>
                                        <div>
                                            <strong>Seats</strong><br>
                                            <span class="text-muted">{{ $listing->specs['seats'] }} seats</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if(isset($listing->specs['doors']))
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-door-open me-2 text-primary"></i>
                                        <div>
                                            <strong>Doors</strong><br>
                                            <span class="text-muted">{{ $listing->specs['doors'] }} doors</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Car Features -->
                @if($listing->specs && isset($listing->specs['features']) && is_array($listing->specs['features']) && count($listing->specs['features']) > 0)
                    <div class="mb-4">
                        <h5>Features & Amenities</h5>
                        <div class="row">
                            @foreach($listing->specs['features'] as $feature)
                                <div class="col-md-6 mb-2">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-check-circle me-2 text-success"></i>
                                        <span>{{ $feature }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Car Owner Info -->
                <div class="mb-4">
                    <h5>Car Owner</h5>
                    <div class="d-flex align-items-center">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3"
                             style="width: 50px; height: 50px;">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div>
                            <strong>{{ $listing->owner->name }}</strong><br>
                            <small class="text-muted">Car owner since {{ $listing->owner->created_at->format('Y') }}</small>
                        </div>
                    </div>
                </div>

                <!-- Availability Calendar (placeholder) -->
                {{-- <div class="mb-4">
                    <h5>Availability</h5>
                    <p class="text-muted">Select your dates in the booking form to check availability.</p>
                </div> --}}
            </div>

            <!-- Booking Sidebar -->
            <div class="col-lg-4">
                <div class="card sticky-top" style="top: 20px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0">${{ number_format($listing->daily_rate, 2) }}</h4>
                            <small class="text-muted">per day</small>
                        </div>

                        @auth
                            @if(auth()->user()->isRenter())
                                @if(auth()->user()->id !== $listing->owner_id)
                                    <form method="POST" action="{{ route('bookings.store', $listing) }}" id="bookingForm">
                                        @csrf

                                        <div class="mb-3">
                                            <label class="form-label">Start Date</label>
                                            <input type="date" class="form-control" name="start_date" id="start_date"
                                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">End Date</label>
                                            <input type="date" class="form-control" name="end_date" id="end_date"
                                                   min="{{ date('Y-m-d', strtotime('+2 days')) }}" required>
                                        </div>

                                        <!-- Price Calculation -->
                                        <div class="mb-3" id="priceCalculation" style="display: none;">
                                            <div class="border rounded p-3 bg-light">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span>${{ number_format($listing->daily_rate, 2) }} × <span id="numberOfDays">0</span> days</span>
                                                    <span id="subtotal">$0.00</span>
                                                </div>
                                                <hr>
                                                <div class="d-flex justify-content-between">
                                                    <strong>Total</strong>
                                                    <strong id="totalPrice">$0.00</strong>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary w-100 mb-3" id="bookButton">
                                            Check Availability & Book
                                        </button>
                                    </form>
                                @else
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        This is your own car. You cannot book it.
                                    </div>
                                @endif
                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Switch to renter account to book this car.
                                </div>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary w-100 mb-3">
                                <i class="fas fa-sign-in-alt me-2"></i>Login to Book
                            </a>
                        @endauth

                        <div class="text-center">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt me-1"></i>
                                Secure booking with instant confirmation
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Additional Car Info -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h6 class="card-title">Quick Info</h6>
                        <div class="mb-2">
                            <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                            <small>{{ $listing->location }}</small>
                        </div>
                        <div class="mb-2">
                            <i class="fas fa-calendar me-2 text-primary"></i>
                            <small>{{ $listing->year }} Model</small>
                        </div>
                        @if($listing->specs && isset($listing->specs['fuel_type']))
                            <div class="mb-2">
                                <i class="fas fa-gas-pump me-2 text-primary"></i>
                                <small>{{ $listing->specs['fuel_type'] }}</small>
                            </div>
                        @endif
                        @if($listing->specs && isset($listing->specs['transmission']))
                            <div>
                                <i class="fas fa-cogs me-2 text-primary"></i>
                                <small>{{ $listing->specs['transmission'] }}</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            const priceCalculation = document.getElementById('priceCalculation');
            const numberOfDaysSpan = document.getElementById('numberOfDays');
            const subtotalSpan = document.getElementById('subtotal');
            const totalPriceSpan = document.getElementById('totalPrice');
            const dailyRate = {{ $listing->daily_rate }};

            function calculatePrice() {
                const startDate = new Date(startDateInput.value);
                const endDate = new Date(endDateInput.value);

                if (startDate && endDate && endDate > startDate) {
                    const diffTime = Math.abs(endDate - startDate);
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    const total = diffDays * dailyRate;

                    numberOfDaysSpan.textContent = diffDays;
                    subtotalSpan.textContent = '$' + total.toFixed(2);
                    totalPriceSpan.textContent = '$' + total.toFixed(2);
                    priceCalculation.style.display = 'block';

                    // Check availability via AJAX
                    checkAvailability(startDateInput.value, endDateInput.value);
                } else {
                    priceCalculation.style.display = 'none';
                }
            }

            function checkAvailability(startDate, endDate) {
                fetch(`{{ route('bookings.check-availability', $listing) }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        start_date: startDate,
                        end_date: endDate
                    })
                })
                .then(response => response.json())
                .then(data => {
                    const bookButton = document.getElementById('bookButton');
                    if (data.available) {
                        bookButton.textContent = 'Book Now - Available';
                        bookButton.className = 'btn btn-success w-100 mb-3';
                        bookButton.disabled = false;
                    } else {
                        bookButton.textContent = 'Not Available';
                        bookButton.className = 'btn btn-danger w-100 mb-3';
                        bookButton.disabled = true;
                    }
                })
                .catch(error => {
                    console.error('Error checking availability:', error);
                });
            }

            // Update end date minimum when start date changes
            startDateInput.addEventListener('change', function() {
                const startDate = new Date(this.value);
                startDate.setDate(startDate.getDate() + 1);
                endDateInput.min = startDate.toISOString().split('T')[0];
                calculatePrice();
            });

            endDateInput.addEventListener('change', calculatePrice);
        });
    </script>
    @endpush
</x-app-layout>
