@extends('admin.layout.master')

@section('title', 'Edit Order')

@section('content')
<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-lg border-1 rounded-lg mt-6">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-2">Edit Order</h3>
                    </div>
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="card-body">
                        <form action="{{ route('orders.update', $order) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="form-group">
                                <label for="order_id">Order ID:</label>
                                <span id="order_id">{{ $order->id }}</span>
                            </div>

                            <div class="form-group">
                                <label for="user_name">User Name:</label>
                                <span id="user_name">{{ $order->user->name }}</span>
                            </div>

                            <div class="form-group">
                                <label for="contact_number">Contact Number:</label>
                                <span id="contact_number">{{ $order->contact_number }}</span>
                            </div>

                            <div class="form-group">
                                <label for="address">Address:</label>
                                <span id="address">{{ $order->address }}</span>
                            </div>

                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="0" {{ $order->status === 0 ? 'selected' : '' }}>Pending</option>
                                    <option value="1" {{ $order->status === 1 ? 'selected' : '' }}>Processing</option>
                                    <option value="2" {{ $order->status === 2 ? 'selected' : '' }}>Shipped</option>
                                    <option value="3" {{ $order->status === 3 ? 'selected' : '' }}>Received</option>
                                    <option value="4" {{ $order->status === 4 ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="products">Products:</label>
                                <ul>
                                    @php $grandTotal = 0; @endphp
                                    @foreach($order->orderProducts as $orderProduct)
                                        <li>Product: {{ $orderProduct->product_title }}</li>
                                        <li>Price: {{ $orderProduct->unit_price }}</li>
                                        <li>Quantity: <input type="number" name="products[{{ $orderProduct->id }}][quantity]" value="{{ $orderProduct->quantity }}" class="form-control"></li>
                                    @endforeach
                                </ul>
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
