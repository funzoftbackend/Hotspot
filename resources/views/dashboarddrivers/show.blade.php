@extends('app')
<style>
    .card-header{
        font-weight:900;
        font-size:25px;
    }
</style>
@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Details</h1>

    <div class="card mb-4">
        <div class="card-header">Driver Information</div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>First Name:</strong> {{ $driver->first_name }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Last Name:</strong> {{ $driver->last_name }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Email:</strong> {{ $driver->email }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Phone Number:</strong> {{ $driver->phone_number }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Latitude:</strong> {{ $driver->latitude }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Longitude:</strong> {{ $driver->longitude }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Passcode:</strong> {{ $driver->passcode }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Select Island:</strong> {{ $driver->select_island }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Profile Image:</strong>
                    @if($driver->image)
                        <img src="{{ asset('public/' . $driver->image) }}" alt="Profile Image" class="img-thumbnail mt-2" width="150">
                    @else
                        <p>No Profile Image uploaded.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Vehicle Information</div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Vehicle Make:</strong> {{ $driver->vehicle_make }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Vehicle Model:</strong> {{ $driver->vehicle_model }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Vehicle Model Year:</strong> {{ $driver->vehicle_model_year }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Vehicle Color:</strong> {{ $driver->vehicle_color }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Vehicle License Plate:</strong> {{ $driver->vehicle_license_plate }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">License Information</div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>License Front Image:</strong>
                    @if($driver->license_front)
                        <img src="{{ asset('public/' . $driver->license_front) }}" alt="License Front" class="img-thumbnail mt-2" width="150">
                    @else
                        <p>No license front image uploaded.</p>
                    @endif
                </div>
                <div class="col-md-6">
                    <strong>License Back Image:</strong>
                    @if($driver->license_back)
                        <img src="{{ asset('public/' . $driver->license_back) }}" alt="License Back" class="img-thumbnail mt-2" width="150">
                    @else
                        <p>No license back image uploaded.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
