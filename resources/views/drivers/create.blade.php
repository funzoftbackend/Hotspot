
@extends('layout.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Sign Up as Driver</h1>
    <form action="{{ route('drivers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Driver Info Section -->
        <div class="card mb-4">
            <div class="card-header">Driver Information</div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" class="form-control" id="first_name" required>
                </div>
                <div class="form-group mb-3">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name" class="form-control" id="last_name" required>
                </div>
                <div class="form-group mb-3">
                    <label for="image">Profile Image</label>
                    <input type="file" name="image" class="form-control-file" id="image">
                </div>
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" id="email" required>
                </div>
                <div class="form-group mb-3">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" name="phone_number" class="form-control" id="phone_number">
                </div>
                <div class="form-group mb-3">
                    <label for="latitude">Latitude</label>
                    <input type="text" name="latitude" class="form-control" id="latitude" required>
                </div>
                <div class="form-group mb-3">
                    <label for="select_island">Select Island</label>
                    <input type="text" name="select_island" class="form-control" id="select_island" required>
                </div>
                <div class="form-group mb-3">
                    <label for="longitude">Longitude</label>
                    <input type="text" name="longitude" class="form-control" id="longitude" required>
                </div>
                <div class="form-group mb-3">
                    <label for="passcode">Passcode</label>
                    <input type="text" name="passcode" class="form-control" id="passcode">
                </div>
            </div>
        </div>

        <!-- Vehicle Info Section -->
        <div class="card mb-4">
            <div class="card-header">Vehicle Information</div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="vehicle_make">Vehicle Make</label>
                    <input type="text" name="vehicle_make" class="form-control" id="vehicle_make">
                </div>
                <div class="form-group mb-3">
                    <label for="vehicle_model">Vehicle Model</label>
                    <input type="text" name="vehicle_model" class="form-control" id="vehicle_model">
                </div>
                <div class="form-group mb-3">
                    <label for="vehicle_model_year">Vehicle Model Year</label>
                    <input type="text" name="vehicle_model_year" class="form-control" id="vehicle_model_year">
                </div>
                <div class="form-group mb-3">
                    <label for="vehicle_color">Vehicle Color</label>
                    <input type="text" name="vehicle_color" class="form-control" id="vehicle_color">
                </div>
                <div class="form-group mb-3">
                    <label for="vehicle_license_plate">Vehicle License Plate</label>
                    <input type="text" name="vehicle_license_plate" class="form-control" id="vehicle_license_plate">
                </div>
            </div>
        </div>

        <!-- License Info Section -->
        <div class="card mb-4">
            <div class="card-header">License Information</div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="license_front">License Front Image</label>
                    <input type="file" name="license_front" class="form-control-file" id="license_front">
                </div>
                <div class="form-group mb-3">
                    <label for="license_back">License Back Image</label>
                    <input type="file" name="license_back" class="form-control-file" id="license_back">
                </div>
            </div>
        </div>

        <button type="submit" class="btn mb-4">Create Driver</button>
    </form>
</div>
@endsection
