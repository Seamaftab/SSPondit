@extends('admin.layout.master')

@section('title', 'Cancelled Orders')

@section('content')
<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-lg border-1 rounded-lg mt-6">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-2">Cancelled Orders</h3>
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-success"><span class="fa fa-list"></span> Go back to Orders</a>
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
                        @if($orders->isNotEmpty())
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>User</th>
                                        <th>Contact Number</th>
                                        <th>Address</th>
                                        <th>Products</th>
                                        <th>Grand Total</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->user->name }}</td>
                                            <td>{{ $order->contact_number }}</td>
                                            <td>{{ $order->address }}</td>
                                            <td>
                                                <ul>
                                                    @php
                                                        $grandTotal = 0;
                                                    @endphp

                                                    @foreach($order->orderProducts as $product)
                                                        <li>{{ $product->product_title }} - {{ $product->quantity }}</li>

                                                        @php
                                                            $grandTotal += ($product->unit_price * $product->quantity);
                                                        @endphp

                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>${{ number_format($grandTotal, 2) }}</td>

                                            <td>{!! $order->status == 0 ? 'Pending' : ($order->status == 1 ? 'Processing' : ($order->status == 2 ? 'Shipped' : ($order->status == 3 ? 'Received' : 'Cancelled'))) !!}
                                            </td>
                                            
                                            <td>
                                                
                                                <form action="{{ route('orders.restored', $order->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-success">Restore Order</button>
                                                </form>

                                                <form action="{{ route('orders.remove', $order->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete Permanently</button>
                                                </form>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>No cancelled orders found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
