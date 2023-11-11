<x-frontend.master>
    <x-slot name="title">Order Confirmation</x-slot>

    <div class="container mt-5">
        @if(session('thank_you'))
            <div class="alert alert-success">
                {{ session('thank_you') }}
            </div>
        @endif

        @if($order)
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Order ID: {{ $order->id }}</h4>
                </div>
                <div class="card-body">
                    <!-- Order details -->
                    <p>User Name: {{ $order->user->name }}</p>
                    <p>Contact Number: {{ $order->contact_number }}</p>
                    <p>Address: {{ $order->address }}</p>
                    <p>Status:
                        @if($order->status === 0)
                            Pending
                        @elseif($order->status === 1)
                            Processing
                        @elseif($order->status === 2)
                            Shipped
                        @elseif($order->status === 3)
                            Delivered
                        @endif
                    </p>
                </div>
            </div>
        @else
            <p>No order found for the current user.</p>
        @endif

        <!-- Back button -->
        <a href="{{ route('welcome') }}" class="btn btn-primary mb-3">Back</a>

        <!-- PDF download button -->
        <a href="{{ route('invoice.pdf', ['order' => $order]) }}" class="btn btn-success mb-3">Download PDF</a>

    </div>
</x-frontend.master>
