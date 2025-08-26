<x-app-layout>
    @section('title', 'Create Car')
    <div class="container my-4">
        <h1>Create New Car Listing</h1>

        <form method="POST" action="{{ route('listings.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Car Title</label>
                                <input type="text" class="form-control" name="title" value="{{ old('title') }}" required>
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
                                                <option value="{{ $make }}" {{ old('make') === $make ? 'selected' : '' }}>{{ $make }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Model</label>
                                        <input type="text" class="form-control" name="model" value="{{ old('model') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Year</label>
                                        <input type="number" class="form-control" name="year" value="{{ old('year') }}" min="1900" max="{{ date('Y') + 1 }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Daily Rate ($)</label>
                                        <input type="number" class="form-control" name="daily_rate" value="{{ old('daily_rate') }}" min="1" step="0.01" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Location</label>
                                        <input type="text" class="form-control" name="location" value="{{ old('location') }}" required>
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
                                                    <option value="Automatic" {{ old('specs.transmission') === 'Automatic' ? 'selected' : '' }}>Automatic</option>
                                                    <option value="Manual" {{ old('specs.transmission') === 'Manual' ? 'selected' : '' }}>Manual</option>
                                                    <option value="CVT" {{ old('specs.transmission') === 'CVT' ? 'selected' : '' }}>CVT</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Fuel Type</label>
                                                <select class="form-control" name="specs[fuel_type]">
                                                    <option value="Gasoline" {{ old('specs.fuel_type') === 'Gasoline' ? 'selected' : '' }}>Gasoline</option>
                                                    <option value="Hybrid" {{ old('specs.fuel_type') === 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                                                    <option value="Electric" {{ old('specs.fuel_type') === 'Electric' ? 'selected' : '' }}>Electric</option>
                                                    <option value="Diesel" {{ old('specs.fuel_type') === 'Diesel' ? 'selected' : '' }}>Diesel</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Seats</label>
                                                <select class="form-control" name="specs[seats]">
                                                    @for($i = 2; $i <= 8; $i++)
                                                        <option value="{{ $i }}" {{ old('specs.seats') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label">Doors</label>
                                                <select class="form-control" name="specs[doors]">
                                                    <option value="2" {{ old('specs.doors') == '2' ? 'selected' : '' }}>2</option>
                                                    <option value="4" {{ old('specs.doors') == '4' ? 'selected' : '' }}>4</option>
                                                    <option value="5" {{ old('specs.doors') == '5' ? 'selected' : '' }}>5</option>
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
                                        $selectedFeatures = old('specs.features', []);
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
                                <label class="form-label">Images</label>
                                <input type="file" class="form-control" name="images[]" multiple accept="image/*">
                                <small class="text-muted">You can select multiple car images to add</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save me-2"></i>Create Car
                            </button>
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary w-100 mt-2">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
