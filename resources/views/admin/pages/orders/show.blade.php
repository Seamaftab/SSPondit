@extends('admin.layout.master')

@section('title', 'Order Details')

@section('content')
<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Order Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="font-weight-bold">Order ID:</h5>
                                <p>{{ $order->id }}</p>
                                <h5 class="font-weight-bold">Contact Number:</h5>
                                <p>{{ $order->contact_number }}</p>
                                <h5 class="font-weight-bold">Delivery Address:</h5>
                                <p>{{ $order->address }}</p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="font-weight-bold">Ordered Products:</h5>
                                <ul>
                                    @foreach($order->orderProducts as $orderProduct)
                                        <li>
                                            <strong>Product Title:</strong> {{ $orderProduct->product_title }}
                                            <br>
                                            <strong>Unit Price:</strong> BDT {{ $orderProduct->unit_price }}
                                            <br>
                                            <strong>Quantity:</strong> {{ $orderProduct->quantity }}
                                        </li>
                                        <br>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-primary mt-4">Back to Orders</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
