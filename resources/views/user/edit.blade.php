@extends('app')
@section('title')
    <title>
        Edit User
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
        <h5 class="card-header">Edit User</h5>
        <div class="card-body">
            <form action="{{ route('user.update', $user->id) }}" enctype="multipart/form-data" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                id="exampleFormControlInput1" placeholder="name@example.com" value="{{ $user->email }}"
                                required />
                        </div>
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">
                                Name</label>
                            <input type="text" name="name" required value="{{ $user->name }}" class="form-control"
                                placeholder="Name" id="name1Input" autocomplete="off" />
                            <div id="name"></div>

                        </div>
                        @error('name')
                            <span>
                                <strong class="text-danger">{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">
                                Address</label>
                            <input type="text" name="address" value="{{ $user->address ? $user->address->address : 'No address available' }}"
                                class="form-control" placeholder="Address"
                                id="address" required autocomplete="off" />
                            <div id="address"></div>

                        </div>
                        @error('address')
                            <span>
                                <strong class="text-danger">{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>


                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Phone</label>
                            <input type="text" name="phone_number" value="{{ $user->phone_number }}"
                                class="form-control @error('phone_number') is-invalid @enderror" placeholder="Phone" required />
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Password</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" placeholder="Password" />
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation"
                                class="form-control  @error('password_confirmation') is-invalid @enderror"
                                placeholder="confirm password" />
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
                        <button class="btn btn-outline-primary" type="submit">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
