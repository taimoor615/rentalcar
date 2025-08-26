<x-app-layout>
    @section('title', 'Edit Car')
    <div class="container my-4">
        <h1>Edit Car Listing</h1>

        <form method="POST" action="{{ route('listings.update', $listing) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Car Title</label>
                                <input type="text" class="form-control" name="title" value="{{ old('title', $listing->title) }}" required>
                                <small class="text-muted">e.g., "2023 Tesla Model 3 - Luxury Electric Sedan"</small>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Make</label>
                                        <select class="form-control" name="make" required>
                                            <option value="">Select Make</option>
                                            @php
                                                $makes = ['Toyota', 'Honda', 'Ford', 'Chevrolet', 'Nissan', 'BMW', 'Mercedes-Benz', 'Audi', 'Volkswagen', 'Hyundai', 'Tesla', 'Jeep', 'Subaru', 'Mazda', 'Kia'];
                                            @endphp
                                            @foreach($makes as $make)
                                                <option value="{{ $make }}" {{ old('make', $listing->make) === $make ? 'selected' : '' }}>{{ $make }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Model</label>
                                        <input type="text" class="form-control" name="model" value="{{ old('model', $listing->model) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Year</label>
                                        <input type="number" class="form-control" name="year" value="{{ old('year', $listing->year) }}" min="1900" max="{{ date('Y') + 1 }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Daily Rate ($)</label>
                                        <input type="number" class="form-control" name="daily_rate" value="{{ old('daily_rate', $listing->daily_rate) }}" min="1" step="0.01" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Location</label>
                                        <input type="text" class="form-control" name="location" value="{{ old('location', $listing->location) }}" required>
                                        <small class="text-muted">e.g., "San Francisco, CA"</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Car Specifications -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h5 class="mb-0">Car Specifications</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Transmission</label>
                                                <select class="form-control" name="specs[transmission]">
                                                    <option value="Automatic" {{ (old('specs.transmission', $listing->specs['transmission'] ?? '') === 'Automatic') ? 'selected' : '' }}>Automatic</option>
                                                    <option value="Manual" {{ (old('specs.transmission', $listing->specs['transmission'] ?? '') === 'Manual') ? 'selected' : '' }}>Manual</option>
                                                    <option value="CVT" {{ (old('specs.transmission', $listing->specs['transmission'] ?? '') === 'CVT') ? 'selected' : '' }}>CVT</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Fuel Type</label>
                                                <select class="form-control" name="specs[fuel_type]">
                                                    <option value="Gasoline" {{ (old('specs.fuel_type', $listing->specs['fuel_type'] ?? '') === 'Gasoline') ? 'selected' : '' }}>Gasoline</option>
                                                    <option value="Hybrid" {{ (old('specs.fuel_type', $listing->specs['fuel_type'] ?? '') === 'Hybrid') ? 'selected' : '' }}>Hybrid</option>
                                                    <option value="Electric" {{ (old('specs.fuel_type', $listing->specs['fuel_type'] ?? '') === 'Electric') ? 'selected' : '' }}>Electric</option>
                                                    <option value="Diesel" {{ (old('specs.fuel_type', $listing->specs['fuel_type'] ?? '') === 'Diesel') ? 'selected' : '' }}>Diesel</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Seats</label>
                                                <select class="form-control" name="specs[seats]">
                                                    @for($i = 2; $i <= 8; $i++)
                                                        <option value="{{ $i }}" {{ (old('specs.seats', $listing->specs['seats'] ?? '') == $i) ? 'selected' : '' }}>{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Doors</label>
                                                <select class="form-control" name="specs[doors]">
                                                    <option value="2" {{ (old('specs.doors', $listing->specs['doors'] ?? '') == '2') ? 'selected' : '' }}>2</option>
                                                    <option value="4" {{ (old('specs.doors', $listing->specs['doors'] ?? '') == '4') ? 'selected' : '' }}>4</option>
                                                    <option value="5" {{ (old('specs.doors', $listing->specs['doors'] ?? '') == '5') ? 'selected' : '' }}>5</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Car Features -->
                            <div class="mb-3">
                                <label class="form-label">Features</label>
                                <div class="row">
                                    @php
                                        $featuresList = [
                                            'GPS Navigation', 'Bluetooth', 'Backup Camera', 'Heated Seats',
                                            'Air Conditioning', 'Cruise Control', 'USB Ports', 'Wireless Charging',
                                            'Apple CarPlay', 'Android Auto', 'Sunroof', 'Leather Seats',
                                            'Premium Sound System', 'Keyless Entry', 'Push Button Start',
                                            'Lane Departure Warning', 'Blind Spot Monitoring', 'Parking Sensors',
                                            'All-Wheel Drive', '4WD', 'Tow Package', 'Roof Rack'
                                        ];
                                        $selectedFeatures = old('specs.features', $listing->specs['features'] ?? []);
                                    @endphp
                                    @foreach($featuresList as $feature)
                                        <div class="col-md-4 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="specs[features][]"
                                                       value="{{ $feature }}" id="feature_{{ $loop->index }}"
                                                       {{ in_array($feature, $selectedFeatures) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="feature_{{ $loop->index }}">
                                                    {{ $feature }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Add New Images</label>
                                <input type="file" class="form-control" name="images[]" multiple accept="image/*">
                                <small class="text-muted">You can select multiple car images to add</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5>Current Car</h5>
                            <div class="mb-3">
                                @if($listing->getFirstMediaUrl('images'))
                                    <img src="{{ asset(parse_url($listing->getFirstMediaUrl('images', 'large'), PHP_URL_PATH)) }}" class="img-fluid rounded mb-2" alt="{{ $listing->title }}">
                                @endif
                                <p class="text-muted">{{ $listing->title }}</p>
                                <p class="text-muted small">{{ $listing->year }} {{ $listing->make }} {{ $listing->model }}</p>
                                <p class="text-muted small">📍 {{ $listing->location }}</p>
                                <p class="text-success fw-bold">${{ number_format($listing->daily_rate, 2) }} / day</p>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save me-2"></i>Update Car
                            </button>
                            <a href="{{ route('listings.show', $listing) }}" class="btn btn-outline-secondary w-100 mt-2">
                                <i class="fas fa-eye me-2"></i>View Car
                            </a>
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary w-100 mt-2">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>

                            <hr>

                            <!-- Car Stats -->
                            <div class="small text-muted">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Listed:</span>
                                    <span>{{ $listing->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Last Updated:</span>
                                    <span>{{ $listing->updated_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Current Images -->
        @if($listing->getMedia('images')->count() > 0)
            <div class="mb-3">
                <label class="form-label">Current Images</label>
                <div class="row">
                    @foreach($listing->getMedia('images') as $media)
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <img src="{{ asset(parse_url($media->getUrl('thumb'), PHP_URL_PATH)) }}" class="card-img-top" alt="{{ $listing->title }}" style="height: 150px; object-fit: cover;">
                                <div class="card-body p-2">
                                    <form method="POST" action="{{ route('media.delete', $media->id) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger w-100"
                                                onclick="return confirm('Are you sure you want to delete this image?')">
                                            <i class="fas fa-trash me-1"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('listings.destroy', $listing) }}" class="mt-3">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger w-25 bg-danger text-white mx-auto d-block"
                    onclick="return confirm('Are you sure you want to delete this car listing? This action cannot be undone.')">
                <i class="fas fa-trash me-2"></i>Delete Car Listing
            </button>
        </form>
    </div>
</x-app-layout>
