@extends('app')
@section('title')
    <title>Create Business</title>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Create Business</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('business.store') }}" method="POST">
                @csrf
                @include('business.partials.form')
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
@endsection
