@extends('app')
@section('title')
    <title>
        Create Driver
    </title>
@endsection
@section('css')
    <style>
        .pointer-cursor {
            cursor: pointer;
        }

        .main {
            padding: 20px;
            background-color: #8FC0E8;
        }

        fieldset {
            border-color: black !important;
        }

        .custom-input {
            background-color: white;
            border: 1px solid white;
            color: black;
            padding: 8px;
            width: 100%;
            outline: none;
            margin-bottom: 3px;
            font-weight: bolder;
        }
    </style>
@endsection
@section('content')
    <div class="card mb-4">
        <h5 class="card-header">Create Driver</h5>
        <div class="card-body">
            <form action="{{ route('dashboard_drivers.store') }}" enctype="multipart/form-data" method="post">
                @csrf
                
                <div class="row">

                    <div class="col-md-12 col-12">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">
                                First Name</label>
                            <input type="text" name="first_name" required value="{{ old('first_name') }}" class="form-control"
                                placeholder="First Name" id="first_name" autocomplete="off" />
                            <div id="first_name"></div>

                        </div>
                        @error('first_name')
                            <span>
                                <strong class="text-danger">{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">
                                Last Name</label>
                            <input type="text" name="last_name" required value="{{ old('last_name') }}" class="form-control"
                                placeholder="Last Name" id="last_name" autocomplete="off" />
                            <div id="last_name"></div>

                        </div>
                        @error('last_name')
                            <span>
                                <strong class="text-danger">{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label" >
                               Profile Image</label>
                            <input type="file" name="image" class="form-control-file" id="image" accept="image/*">
                            <div id="image"></div>

                        </div>
                        @error('image')
                            <span>
                                <strong class="text-danger">{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="mb-3 mt-2">
                            <label for="exampleFormControlInput1" class="form-label">Email</label>
                            <input type="email" value="{{ old('email') }}" name="email"
                                class="form-control @error('email') is-invalid @enderror" id="exampleFormControlInput1"
                                placeholder="name@example.com" required />

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                    </div>


                   
                    <div class="ccol-md-12 col-12">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">
                                Phone Number</label>
                            <input type="text" name="phone_number" value="{{ old('phone_number') }}"
                                class="form-control @error('phone_number') is-invalid @enderror"
                                placeholder="Phone Number" required />
                        </div>
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">
                                Select Island</label>
                            <input type="text" name="select_island" value="{{ old('select_island') }}"
                                class="form-control" required placeholder="Island"
                                id="select_island" autocomplete="off" />
                            {{-- <div id="select_island"></div> --}}
                        </div>
                        @error('select_island')
                            <span>
                                <strong class="text-danger">{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="mb-3">
                            <label for="latitude" class="form-label">
                                Latitude</label>
                            <input type="text" name="latitude" value="{{ old('latitude') }}"
                                class="form-control" required placeholder="Latitude"
                                id="latitude" autocomplete="off" />
                            {{-- <div id="latitude"></div> --}}
                        </div>
                        @error('latitude')
                            <span>
                                <strong class="text-danger">{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="mb-3">
                            <label for="longitude" class="form-label">
                                Longitude</label>
                            <input type="text" name="longitude" value="{{ old('longitude') }}"
                                class="form-control" required placeholder="Longitude"
                                id="longitude" autocomplete="off" />
                            {{-- <div id="longitude"></div> --}}
                        </div>
                        @error('longitude')
                            <span>
                                <strong class="text-danger">{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="mb-3">
                            <label for="passcode" class="form-label">
                                Passcode</label>
                            <input type="text" name="passcode" value="{{ old('passcode') }}"
                                class="form-control" required placeholder="Passcode"
                                id="passcode" autocomplete="off" />
                            {{-- <div id="passcode"></div> --}}
                        </div>
                        @error('passcode')
                            <span>
                                <strong class="text-danger">{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="mb-3">
                            <label for="vehicle_make" class="form-label">
                           Vehicle Make</label>
                            <input type="text" name="vehicle_make" value="{{ old('vehicle_make') }}"
                                class="form-control" required placeholder="Vehicle Make"
                                id="vehicle_make" autocomplete="off" />
                            {{-- <div id="vehicle_make"></div> --}}
                        </div>
                        @error('vehicle_make')
                            <span>
                                <strong class="text-danger">{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="mb-3">
                            <label for="vehicle_color" class="form-label">
                           Vehicle Color</label>
                            <input type="text" name="vehicle_color" value="{{ old('vehicle_color') }}"
                                class="form-control" required placeholder="Vehicle Color"
                                id="vehicle_color" autocomplete="off" />
                            {{-- <div id="vehicle_color"></div> --}}
                        </div>
                        @error('vehicle_color')
                            <span>
                                <strong class="text-danger">{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="mb-3">
                            <label for="vehicle_model" class="form-label">
                            Vehicle Model</label>
                            <input type="text" name="vehicle_model" value="{{ old('vehicle_model') }}"
                                class="form-control" required placeholder="Vehicle Model"
                                id="vehicle_model" autocomplete="off" />
                            {{-- <div id="vehicle_model"></div> --}}
                        </div>
                        @error('vehicle_model')
                            <span>
                                <strong class="text-danger">{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="mb-3">
                            <label for="vehicle_model_year" class="form-label">
                            Vehicle Model Year</label>
                            <input type="text" name="vehicle_model_year" value="{{ old('vehicle_model_year') }}"
                                class="form-control" required placeholder="Vehicle Model Year"
                                id="vehicle_model_year" autocomplete="off" />
                            {{-- <div id="vehicle_model_year"></div> --}}
                        </div>
                        @error('vehicle_model_year')
                            <span>
                                <strong class="text-danger">{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="mb-3">
                            <label for="vehicle_licence_plate" class="form-label">
                                Vehicle License Plate</label>
                            <input type="text" name="vehicle_licence_plate" value="{{ old('vehicle_licence_plate') }}"
                                class="form-control" required placeholder="Vehicle License Plate"
                                id="vehicle_licence_plate" autocomplete="off" />
                            {{-- <div id="passcode"></div> --}}
                        </div>
                        @error('vehicle_licence_plate')
                            <span>
                                <strong class="text-danger">{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="mb-3">
                            <label for="license_front" class="form-label">
                              License Front</label>
                            <input type="file" name="license_front" class="form-control-file" id="license_front" accept="image/*">
                            <div id="license_front"></div>

                        </div>
                        @error('license_front')
                            <span>
                                <strong class="text-danger">{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="mb-3">
                            <label for="license_back" class="form-label">
                            License Back</label>
                            <input type="file" name="license_back" class="form-control-file" id="license_back" accept="image/*">
                            <div id="license_back"></div>

                        </div>
                        @error('license_back')
                            <span>
                                <strong class="text-danger">{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>


                <div class="row">
                    

                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1"
                                class="form-label">Password</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Password" required />
                            @error('Password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1"
                                class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation"
                                class="form-control  @error('password_confirmation') is-invalid @enderror"
                                placeholder="Confirm Password" required />
                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="mb-3">
                            <input type="checkbox" name="save_address" id="save_address" class="form-check-input">
                            <label for="save_address"
                                class="form-check-label">Save Address for Future</label>
                        </div>
                    </div>

                    <div class="text-end">
                        <button class="btn btn-outline-primary" type="submit">
                            Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

