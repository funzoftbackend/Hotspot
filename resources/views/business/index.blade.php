@extends('app')
@section('title')
    <title>Businesses</title>
@endsection

@section('content')
    <div class="card">
        <h5 class="card-header">
            Businesses
            <div class="text-end">
                <a href="{{ route('business.create') }}" class="btn btn-outline-primary">Create Business</a>
            </div>
        </h5>
        <div class="col-xl-12">
            <div class="container p-4">
                <div class="table-responsive text-nowrap">
                    <table class="table" id="admin">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Location</th>
                                <th>Delivery</th>
                                <th>Pickup</th>
                                <th>Monday</th>
                                <th>Tuesday</th>
                                <th>Wednesday</th>
                                <th>Thursday</th>
                                <th>Friday</th>
                                <th>Saturday</th>
                                <th>Sunday</th>
                                <th>Business Status</th>
                                <th>Business Image</th>
                                <th>Logo Image</th>
                                <th>Promo Images</th>
                                <th>Category ID</th>
                                <th>Rating</th>
                                <th>Delivery Time</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($businesses as $business)
                                <tr>
                                    <td>{{ $business->name }}</td>
                                    <td>{{ $business->email }}</td>
                                    <td>{{ $business->phone }}</td>
                                    <td>{{ $business->location }}</td>
                                    <td>{{ $business->delivery }}</td>
                                    <td>{{ $business->pickup }}</td>
                                    <td>{{ $business->monday }}</td>
                                    <td>{{ $business->tuesday }}</td>
                                    <td>{{ $business->wednesday }}</td>
                                    <td>{{ $business->thursday }}</td>
                                    <td>{{ $business->friday }}</td>
                                    <td>{{ $business->saturday }}</td>
                                    <td>{{ $business->sunday }}</td>
                                    <td>{{ $business->business_status }}</td>
                                    <td>{{ $business->business_image }}</td>
                                    <td>{{ $business->logo_image }}</td>
                                    <td>{{ $business->promo_images }}</td>
                                    <td>{{ $business->category_id }}</td>
                                    <td>{{ $business->rating }}</td>
                                    <td>{{ $business->delivery_time }}</td>
                                    <td>{{ $business->latitude }}</td>
                                    <td>{{ $business->longitude }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('business.edit', $business->id) }}"><i class="bx bx-edit-alt me-1 text-success"></i> Edit</a>
                                                <a class="dropdown-item" href="{{ route('business.destroy', $business->id) }}" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $business->id }}').submit();"><i class="bx bx-trash me-1 text-danger"></i> Delete</a>
                                                <form id="delete-form-{{ $business->id }}" action="{{ route('business.destroy', $business->id) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
