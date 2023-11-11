@extends('admin.layout.master')

@section('title', 'Orders')

@section('content')
<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-lg border-1 rounded-lg mt-6">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-2">Order List</h3>
                        <a href="{{route('welcome')}}" class="btn btn-outline-info"><span class="fa fa-list"></span> Back</a>
                        <a href="{{route('cancelled_orders')}}" class="btn btn-sm btn-outline-danger">Cancelled Orders</a>
                    </div>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('info'))
                        <div class="alert alert-info">
                            {{ session('info') }}
                        </div>
                    @endif

                    @if(session('danger'))
                        <div class="alert alert-danger">
                            {{ session('danger') }}
                        </div>
                    @endif
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="font-weight: bold;">Order ID</th>
                                    <th style="font-weight: bold;">User Name</th>
                                    <th style="font-weight: bold;">Contact Number</th>
                                    <th style="font-weight: bold;">Address</th>
                                    <th style="font-weight: bold;">Status</th>
                                    <th style="font-weight: bold;">Products</th>
                                    <th style="font-weight: bold;">Grand Total</th>
                                    <th style="font-weight: bold;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->contact_number }}</td>
                                    <td>{{ $order->address }}</td>
                                    <td>{!! $order->status == 0 ? 'Pending' : ($order->status == 1 ? 'Processing' : ($order->status == 2 ? 'Shipped' : ($order->status == 3 ? 'Received' : 'Cancelled'))) !!}</td>
                                    <td>
                                        <ul>
                                            @php
                                                $grandTotal = 0;
                                            @endphp
                                            @foreach($order->orderProducts as $orderProduct)
                                                <li>Product: {{ $orderProduct->product_title }}</li>
                                                <li>Price: {{ $orderProduct->unit_price }}</li>
                                                <li>Quantity: {{ $orderProduct->quantity }}</li>
                                                @php
                                                    $grandTotal += $orderProduct->unit_price * $orderProduct->quantity;
                                                @endphp
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>{{ $grandTotal }}</td>
                                    <td>
                                        <a href="{{ route('orders.show', $order) }}" class="btn-sm btn-outline-info"><span class="fa fa-eye"></span> Show Order</a>
                                        <a href="{{ route('orders.edit', $order) }}" class="btn-sm btn-outline-dark"><span class="fa fa-pencil"></span> Edit</a>
                                        <form method="POST" action="{{route('orders.cancel', $order) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-sm btn-outline-secondary"><span class="fa fa-eraser"></span></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
