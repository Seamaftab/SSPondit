<!DOCTYPE html>
<html>
<head>
    <title>Invoice - Shop in Style</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .invoice {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
        }
        .thank-you {
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="invoice">
        <h1>Shop in Style</h1>
        <h3>Your trusted shopping spree place</h3>
        <div class="thank-you">
            <p>Thank you for choosing Shop in Style for your shopping needs. We appreciate your business.</p>
        </div>
        <h2>User Information:</h2>
        <p>User Name: {{ $order->user->name }}</p>
        <p>Contact Number: {{ $order->contact_number }}</p>
        <p>Address: {{ $order->address }}</p>
        <h2>Product Details:</h2>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $grandTotal = 0;
                @endphp
                @foreach($order->orderProducts as $product)
                <tr>
                    <td>{{ $product->product_title }}</td>
                    <td>BDT {{ $product->unit_price }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>BDT {{ $product->unit_price * $product->quantity }}</td>
                    @php
                        $grandTotal += $product->unit_price * $product->quantity;
                    @endphp
                </tr>
                @endforeach
                <tr>
                    <td colspan="3"><strong>Grand Total</strong></td>
                    <td><strong>BDT {{ $grandTotal }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
