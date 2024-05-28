@extends('app')
@section('title')
    <title>
        Orders
    </title>
@endsection

@section('content')
    <div class="card">

        <h5 class="card-header">

            Orders
        </h5>

        <div class="col-xl-12">
            <div class="container p-4">
                <div class="table-responsive text-nowrap">
                    <table class="table" id="admin">
                        <thead>
                            <tr>
                                <th>Order No</th>
                                <th>Min Time</th>
                                <th>Max Time</th>
                                <th>Delivery Stage</th>
                                <th>Order Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">

                            @foreach ($orders as $order)
                                <tr>
                                    <td>
                                        <span class="fw-medium">{{ $order->order_no }}</span>
                                    </td>
                                    <td>{{ $order->min_time }}</td>
                                    <td>
                                    {{ $order->max_time }}
                                    </td>
                                    @if($order->delivery_stage == 1)
                                    <td>
                                      Placed 
                                    </td>
                                    @elseif($order->delivery_stage == 2)
                                    <td>
                                      Prepared
                                    </td>
                                    @elseif($order->delivery_stage == 3)
                                    <td>
                                      Picked 
                                    </td>
                                    @else
                                    <td>
                                      Delivered 
                                    </td>
                                    @endif
                                    <td>
                                        {{ ucfirst($order->order_status) }}
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item"
                                                    href="{{ route('order.show', ['order_id' => $order->id]) }}"><i
                                                        class="bx bx-show-alt me-1 text-primary"></i>
                                                    View
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
