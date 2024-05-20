
@extends('layout.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Details</h1>

    <div class="card mb-4">
        <div class="card-header">Driver Information</div>
        <div class="card-body">
            <p><strong>First Name:</strong> {{ $driver->first_name }}</p>
            <p><strong>Last Name:</strong> {{ $driver->last_name }}</p>
            <p><strong>Email:</strong> {{ $driver->email }}</p>
            <p><strong>Phone Number:</strong> {{ $driver->phone_number }}</p>
            <p><strong>Latitude:</strong> {{ $driver->latitude }}</p>
            <p><strong>Longitude:</strong> {{ $driver->longitude }}</p>
            <p><strong>Passcode:</strong> {{ $driver->passcode }}</p>
            <p><strong>Select Island:</strong> {{ $driver->select_island }}</p>
             <div>
                <strong>Profile Image:</strong>
                @if($driver->image)
                    <img src="{{ asset('public/' . $driver->image) }}" alt="Profile Image" class="img-thumbnail mt-2" width="150">
                @else
                    <p>No Profile Image uploaded.</p>
                @endif
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">Vehicle Information</div>
        <div class="card-body">
            <p><strong>Vehicle Make:</strong> {{ $driver->vehicle_make }}</p>
            <p><strong>Vehicle Model:</strong> {{ $driver->vehicle_model }}</p>
            <p><strong>Vehicle Model Year:</strong> {{ $driver->vehicle_model_year }}</p>
            <p><strong>Vehicle Color:</strong> {{ $driver->vehicle_color }}</p>
            <p><strong>Vehicle License Plate:</strong> {{ $driver->vehicle_license_plate }}</p>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">License Information</div>
        <div class="card-body">
            <div>
                <strong>License Front Image:</strong>
                @if($driver->license_front)
                    <img src="{{ asset('public/' . $driver->license_front) }}" alt="License Front" class="img-thumbnail mt-2" width="150">
                @else
                    <p>No license front image uploaded.</p>
                @endif
            </div>
            <div>
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
@endsection
