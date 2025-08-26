<x-app-layout>
    @section('title', 'Car Rentals')
    <!-- Hero Section -->
    <div class="bg-light py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h1 class="text-center mb-4">Find Your Perfect Ride</h1>

                    <!-- Search Form -->
                    <form method="GET" action="{{ route('listings.index') }}" class="card p-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label small text-muted">Daily Rate (Min)</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" name="min_price"
                                           placeholder="0" value="{{ request('min_price') }}" min="0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small text-muted">Daily Rate (Max)</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" name="max_price"
                                           placeholder="500" value="{{ request('max_price') }}" min="0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small text-muted">Car Make</label>
                                <select class="form-control" name="make">
                                    <option value="">Any Make</option>
                                    <option value="Toyota" {{ request('make') === 'Toyota' ? 'selected' : '' }}>Toyota</option>
                                    <option value="Honda" {{ request('make') === 'Honda' ? 'selected' : '' }}>Honda</option>
                                    <option value="Ford" {{ request('make') === 'Ford' ? 'selected' : '' }}>Ford</option>
                                    <option value="BMW" {{ request('make') === 'BMW' ? 'selected' : '' }}>BMW</option>
                                    <option value="Mercedes-Benz" {{ request('make') === 'Mercedes-Benz' ? 'selected' : '' }}>Mercedes-Benz</option>
                                    <option value="Audi" {{ request('make') === 'Audi' ? 'selected' : '' }}>Audi</option>
                                    <option value="Tesla" {{ request('make') === 'Tesla' ? 'selected' : '' }}>Tesla</option>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label small text-muted">Location</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <input type="text" class="form-control" name="location"
                                           placeholder="City, State" value="{{ request('location') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small text-muted">&nbsp;</label>
                                <button type="submit" class="btn btn-primary w-100 d-block">
                                    <i class="fas fa-search me-2"></i>Search Cars
                                </button>
                            </div>
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text" class="form-control" name="search"
                                           placeholder="Search by car name, make, or model..." value="{{ request('search') }}">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Cars Grid -->
    <div class="container my-5">
        @if($listings->count() > 0)
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4>Available Cars ({{ $listings->total() }})</h4>
                <div class="text-muted small">
                    Showing {{ $listings->firstItem() }}-{{ $listings->lastItem() }} of {{ $listings->total() }} results
                </div>
            </div>

            <div class="row g-4">
                @foreach($listings as $listing)
                    <div class="col-lg-4 col-md-6">
                        <div class="card listing-card h-100 shadow-sm">
                            @if($listing->getFirstMediaUrl('images'))
                                <img src="{{ asset(parse_url($listing->getFirstMediaUrl('images', 'thumb'), PHP_URL_PATH)) }}"
                                     class="card-img-top listing-image"
                                     alt="{{ $listing->title }}"
                                     style="height: 250px; object-fit: cover;">
                            @else
                                <div class="card-img-top listing-image bg-light d-flex align-items-center justify-content-center"
                                     style="height: 250px;">
                                    <div class="text-center text-muted">
                                        <i class="fas fa-car fa-3x mb-2"></i>
                                        <br>No Image Available
                                    </div>
                                </div>
                            @endif

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $listing->title }}</h5>

                                <!-- Car Details -->
                                <div class="mb-2">
                                    <span class="badge bg-primary me-1">{{ $listing->year }}</span>
                                    <span class="text-muted">{{ $listing->make }} {{ $listing->model }}</span>
                                </div>

                                <p class="text-muted small mb-2">
                                    <i class="fas fa-map-marker-alt me-1"></i>{{ $listing->location }}
                                </p>

                                <!-- Car Specs (if available) -->
                                @if($listing->specs)
                                    <div class="mb-3">
                                        <div class="row text-center small">
                                            @if(isset($listing->specs['seats']))
                                                <div class="col">
                                                    <i class="fas fa-users text-muted"></i><br>
                                                    <small class="text-muted">{{ $listing->specs['seats'] }} seats</small>
                                                </div>
                                            @endif
                                            @if(isset($listing->specs['transmission']))
                                                <div class="col">
                                                    <i class="fas fa-cogs text-muted"></i><br>
                                                    <small class="text-muted">{{ $listing->specs['transmission'] }}</small>
                                                </div>
                                            @endif
                                            @if(isset($listing->specs['fuel_type']))
                                                <div class="col">
                                                    <i class="fas fa-gas-pump text-muted"></i><br>
                                                    <small class="text-muted">{{ $listing->specs['fuel_type'] }}</small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <!-- Features Preview -->
                                @if($listing->specs && isset($listing->specs['features']) && count($listing->specs['features']) > 0)
                                    <div class="mb-3">
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach(array_slice($listing->specs['features'], 0, 3) as $feature)
                                                <span class="badge bg-light text-dark small">{{ $feature }}</span>
                                            @endforeach
                                            @if(count($listing->specs['features']) > 3)
                                                <span class="badge bg-secondary small">+{{ count($listing->specs['features']) - 3 }} more</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <!-- Price and Owner -->
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <span class="fw-bold text-success fs-5">${{ number_format($listing->daily_rate, 0) }}</span>
                                            <small class="text-muted">/ day</small>
                                        </div>
                                        <div class="text-muted small">
                                            <i class="fas fa-user me-1"></i>{{ $listing->owner->name }}
                                        </div>
                                    </div>

                                    <!-- Rating placeholder -->
                                    <div class="mb-2">
                                        <div class="d-flex align-items-center">
                                            <div class="text-warning small me-2">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                            <small class="text-muted">(4.0) • Popular</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer bg-transparent">
                                <div class="row g-2">
                                    <div class="col">
                                        <a href="{{ route('listings.show', $listing) }}" class="btn btn-outline-primary w-100">
                                            <i class="fas fa-eye me-1"></i>View Details
                                        </a>
                                    </div>
                                    {{-- <div class="col">
                                        <a href="{{ route('listings.show', $listing) }}#booking" class="btn btn-primary w-100">
                                            <i class="fas fa-calendar-check me-1"></i>Book Now
                                        </a>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5">
                {{ $listings->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-car fa-4x text-muted"></i>
                </div>
                <h3 class="text-muted">No cars found</h3>
                <p class="text-muted">Try adjusting your search criteria or browse all available cars.</p>
                <a href="{{ route('listings.index') }}" class="btn btn-primary">
                    <i class="fas fa-search me-2"></i>View All Cars
                </a>
            </div>
        @endif
    </div>

    @push('styles')
    <style>
        .listing-card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            border: none;
            border-radius: 12px;
            overflow: hidden;
        }
        .listing-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
        }
        .listing-image {
            border-radius: 0;
        }
        .badge {
            font-size: 0.75em;
        }
        .card-footer {
            border-top: 1px solid #f0f0f0;
        }
        .input-group-text {
            background-color: #f8f9fa;
            border-color: #dee2e6;
        }
        .form-label.small {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        // Auto-submit form when filters change (optional)
        document.addEventListener('DOMContentLoaded', function() {
            const makeSelect = document.querySelector('select[name="make"]');
            if (makeSelect) {
                makeSelect.addEventListener('change', function() {
                    // Optionally auto-submit the form
                    // this.closest('form').submit();
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
