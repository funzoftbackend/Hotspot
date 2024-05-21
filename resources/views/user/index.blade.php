@extends('app')
@section('title')
    <title>
        Users
    </title>
@endsection

@section('content')
    <div class="card">

        <h5 class="card-header">

            Users
            <div class="text-end">
                <a href="{{ route('user.create') }}"
                    class="btn btn-outline-primary">Create User</a>
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
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">

                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <span class="fw-medium">{{ ucfirst($user->name) }}</span>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    @if(!empty($user->address))
                                        <td>
                                        {{ $user->address->address }}
                                        </td>
                                    @else
                                        <td>
                                            Address Not Found
                                        </td>
                                    @endif
                                    <td>
                                        {{ $user->phone_number }}
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item"
                                                    href="{{ route('user.edit', ['user_id' => $user->id]) }}"><i
                                                        class="bx bx-edit-alt me-1 text-success"></i>
                                                    Edit
                                                </a>
                                                <a class="dropdown-item"
                                                    href="{{ route('user.destroy', ['user' => $user]) }}"><i
                                                        class="bx bx-trash me-1 text-danger"></i>
                                                    Delete

                                                </a>
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
    <!--/ Basic Bootstrap Table -->
@endsection
