@extends('app')

@section('title')
    <title>
        User Details
    </title>
@endsection

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">User Details</h1>

    <div class="card mb-4">
        <div class="card-header">User Information</div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Name:</strong> {{ $user->name }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Phone Number:</strong> {{ $user->phone_number }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>User Type:</strong> {{ $user->user_type }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>SID:</strong> {{ $user->sid }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Social Name:</strong> {{ $user->social_name }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <strong>User Image:</strong>
                    @if($user->image)
                        <img src="{{ asset('/public/'.$user->image) }}" alt="User Image" class="img-thumbnail mt-2" width="150">
                    @else
                        <p>No user image uploaded.</p>
                    @endif
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
