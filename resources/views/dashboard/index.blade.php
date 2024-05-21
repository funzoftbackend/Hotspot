@extends('app')
@section('title')
    <title>
        Hotspot
    </title>
@endsection
@section('content')

    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Congratulations 🎉
                                {{ucfirst($user->name)}} </h5>
                            <p class="mb-4">
                                Successfully Logged In as {{$user->user_type}}

                            </p>

                            {{-- <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a> --}}
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="{{asset('/public/assets/img/illustrations/man-with-laptop-light.png')}}" height="140"
                                alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                data-app-light-img="illustrations/man-with-laptop-light.png" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 order-1">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-6 mb-4">
                        <a href="{{ route('user.index') }}">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="bi bi-gear display-4 text-success mt-5 "></i>
                                    <span class="fw-medium d-block mb-3 text-dark">All Users
                                    </span>
                                    <h3 class="card-title">{{ $totalusers }}</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 col-6 mb-4">
                        <a href="">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="bi bi-truck display-4 text-success mt-5 "></i>
                                    <span class="fw-medium d-block mb-3  text-dark">Driver</span>
                                    <h3 class="card-title"> {{ $totaldrivers }}</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 col-6 mb-4">
                        <a href="">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="bi bi-people display-4 text-success mt-5 "></i>
                                    <span
                                        class="fw-medium d-block mb-3  text-dark">Businesses</span>
                                    <h3 class="card-title">{{ $totalbusinesses }}</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                    
                </div>
            </div>

        </div>

    </div>

    </div>
@endsection
