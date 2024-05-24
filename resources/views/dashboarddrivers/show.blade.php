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
                 <div class="col-md-6 mbb-2">
                    @if($driver->is_verified == 1)
                    @else
                    <form action="{{ route('dashboard_drivers.verify', ['driver_id' => $driver->id]) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-info btn-sm">Verify</button>
                    </form>
                    @endif
                    @if($driver->is_verified == 1)
                            <button type="button" class="btn btn-danger unverify-button" data-toggle="modal" data-target="#rejectModal_{{ $driver->id }}">Unverify</button>
                            <div id="rejectModal_{{ $driver->id }}" class="modal" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Unverification Reason</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border: none; background: none;">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" id="reject-form-{{ $driver->id }}" action="{{ route('dashboard_drivers.unverify') }}">
                                                @csrf
                                                <input type="hidden" name="driver_id" value="{{ $driver->id }}">
                                                <div class="form-group">
                                                    <textarea name="reason" class="form-control reason-input" id="reason" placeholder="Enter Unverification reason" style="width: 100%; height: 100px;" required></textarea>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                                            <button type="button" class="btn btn-danger mt-2" onclick="submitRejectForm({{ $driver->id }})">Confirm Unverification</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
        $(document).ready(function() {
        // Show reason input when unverify button is clicked
        $('.unverify-button').on('click', function() {
            var driverId = $(this).closest('.card').find('input[name="driver_id"]').val();
            $('#rejectModal_' + driverId).modal('show');
        });
    
        // Close modal when cancel button is clicked
        $('.close').on('click', function() {
            $(this).closest('.modal').modal('hide');
        });
    
        // Close modal when cancel primary button is clicked
        $('.btn-primary').on('click', function() {
            $(this).closest('.modal').modal('hide');
        });
    
        // Validate rejection reason before form submission
        $(document).on('click', '.btn-danger.mt-2', function(e)  {
            e.preventDefault();
            var reasonInput = $(this).closest('.modal').find('.reason-input');
            var reason = reasonInput.val().trim();
            if (!reason) {
                alert('Please enter a unverification reason first.');
            } else {
                $(this).closest('.modal').find('form').submit();
            }
        });
    });

</script>
@endsection
