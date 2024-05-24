@extends('app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Business Details</h1>

    <div class="card mb-4">
        <div class="card-header">Business Information</div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Name:</strong> {{ $business->name }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Email:</strong> {{ $business->email }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Phone:</strong> {{ $business->phone }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Location:</strong> {{ $business->location }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Delivery:</strong> {{ $business->delivery }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Pickup:</strong> {{ $business->pickup }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Business Status:</strong> {{ $business->business_status }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Business Image:</strong>
                    @if($business->business_image)
                        <img src="{{ $business->business_image }}" alt="Business Image" class="img-thumbnail mt-2" width="150">
                    @else
                        <p>No business image uploaded.</p>
                    @endif
                </div>
                <div class="col-md-6">
                    <strong>Logo Image:</strong>
                    @if($business->logo_image)
                        <img src="{{ $business->logo_image }}" alt="Logo Image" class="img-thumbnail mt-2" width="150">
                    @else
                        <p>No logo image uploaded.</p>
                    @endif
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <strong>Promo Images:</strong>
                    @if($business->promo_images)
                        @foreach(json_decode($business->promo_images) as $image)
                            <img src="{{ asset('public/business/promo_image/' . $image) }}" alt="Promo Image" class="img-thumbnail mt-2" width="150">
                        @endforeach
                    @else
                        <p>No promo images uploaded.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Operation Hours</div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Monday:</strong> {{ $business->monday }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Tuesday:</strong> {{ $business->tuesday }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Wednesday:</strong> {{ $business->wednesday }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Thursday:</strong> {{ $business->thursday }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Friday:</strong> {{ $business->friday }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Saturday:</strong> {{ $business->saturday }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Sunday:</strong> {{ $business->sunday }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Additional Information</div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Category ID:</strong> {{ $business->category_id }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Rating:</strong> {{ $business->rating }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Delivery Time:</strong> {{ $business->delivery_time }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Latitude:</strong> {{ $business->latitude }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Longitude:</strong> {{ $business->longitude }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    .card-header {
        font-weight: 900;
        font-size: 25px;
    }
</style>
