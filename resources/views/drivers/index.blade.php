
@extends('layout.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Drivers</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Profile Image</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Select Island</th>
                    <th>Latitude</th>
                    <th>Passcode</th>
                    <th>Longitude</th>
                    <th>Vehicle Make</th>
                     <th>Vehicle Color</th>
                    <th>Vehicle Model</th>
                    <th>Vehicle Model Year</th>
                    <th>Vehicle License Plate</th>
                    <th>Status</th>
                    <th>License Front</th>
                    <th>License Back</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($drivers as $driver)
                <tr>
                    <td>{{ $driver->id }}</td>
                    <td>{{ $driver->first_name }}</td>
                    <td>{{ $driver->last_name }}</td>
                    <td>
                        @if($driver->image)
                            <img src="{{ asset('public/' . $driver->image) }}" alt="Image" class="img-thumbnail" width="50">
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $driver->email }}</td>
                    <td>{{ $driver->phone_number }}</td>
                    <td>{{ $driver->select_island }}</td>
                    <td>{{ $driver->latitude }}</td>
                    <td>{{ $driver->passcode }}</td>
                    <td>{{ $driver->longitude }}</td>
                    <td>{{ $driver->vehicle_make }}</td>
                    <td>{{ $driver->vehicle_color }}</td>
                    <td>{{ $driver->vehicle_model }}</td>
                    <td>{{ $driver->vehicle_model_year }}</td>
                    <td>{{ $driver->vehicle_license_plate }}</td>
                    @if($driver->is_verified == 1)
                    <td>Verified</td>
                    @else
                    <td>Not Verified</td>
                    @endif
                    <td>
                        @if($driver->license_front)
                            <img src="{{ asset('public/' . $driver->license_front) }}" alt="License Front" class="img-thumbnail" width="50">
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        @if($driver->license_back)
                            <img src="{{ asset('public/' . $driver->license_back) }}" alt="License Back" class="img-thumbnail" width="50">
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('drivers.show', $driver) }}" class="btn btn-info btn-sm">View</a>
                        @if($driver->is_verified == 1)
                        @else
                        <form action="{{ route('drivers.verify', $driver) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-info btn-sm">Verify</button>
                        </form>
                        @endif
                        
                        <form action="{{ route('drivers.destroy', $driver) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger mt btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
