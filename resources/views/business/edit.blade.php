@extends('app')
@section('title')
    <title>Edit Business</title>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Edit Business</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('business.update', $business->id) }}" method="POST">
                @csrf
                @include('business.partials.form', ['business' => $business])
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
