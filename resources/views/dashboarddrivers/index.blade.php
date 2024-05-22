@extends('app')
@section('title')
    <title>
        Drivers
    </title>
@endsection

@section('content')
    <!-- Basic Bootstrap Table -->
    <div class="card">

        <h5 class="card-header">

           Drivers
            <div class="text-end">
                <a href="{{ route('dashboard_drivers.create') }}"
                    class="btn btn-outline-primary">Create Drivers</a>
            </div>
        </h5>

        <div class="col-xl-12">
            <div class="container p-4">
                <div class="table-responsive text-nowrap">
                    <table class="table" id="admin">
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
                                    <a href="{{ route('dashboard_drivers.show', ['driver_id' => $driver->id]) }}" class="btn btn-info btn-sm">View</a>
                                    <a href="{{ route('drivers.edit', ['driver_id' => $driver->id]) }}" class="btn btn-primary btn-sm">Edit</a>
                                    @if($driver->is_verified == 1)
                                    @else
                                    <form action="{{ route('dashboard_drivers.verify', $driver) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-info btn-sm">Verify</button>
                                    </form>
                                    @endif
                                    
                                    <form action="{{ route('dashboard_drivers.destroy', $driver) }}" method="POST" style="display:inline;">
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
        </div>





    </div>
    <!--/ Basic Bootstrap Table -->
@endsection
