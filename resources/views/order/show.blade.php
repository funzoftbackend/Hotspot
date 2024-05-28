@extends('app')

@section('title')
    <title>
        Order Details
    </title>
@endsection

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Order Details</h1>

    <div class="card mb-4">
        <div class="card-header">Order Information</div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Order No:</strong> {{ $order->order_no }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Min Time:</strong> {{ $order->min_time }}</p>
                </div>
                
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Max Time:</strong> {{ $order->max_time }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Delivery Stage:</strong>
                    @if($order->delivery_stage == 1)
                        Placed</p>
                    @elseif($order->delivery_stage == 2)
                        Prepared</p>
                    @elseif($order->delivery_stage == 3)
                        Picked</p>
                    @else
                        Delivered</p>
                    @endif

                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Order Status:</strong> {{ ucfirst($order->order_status) }}</p>
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
