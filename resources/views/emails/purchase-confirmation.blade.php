<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 20px 0;
            background-color: #D4AF37;
            color: #2c1e1e;
        }
        .content {
            padding: 20px;
            background-color: #f9f9f9;
        }
        .order-details {
            margin: 20px 0;
        }
        .item {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .total {
            text-align: right;
            font-weight: bold;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Purchase Confirmation</h1>
        </div>
        <div class="content">
            <p>Dear {{ $user->name }},</p>
            <p>Thank you for your purchase! Here are your order details:</p>

            <div class="order-details">
                <h3>Order Summary</h3>
                @foreach($items as $item)
                <div class="item">
                    <p><strong>{{ $item->name }}</strong></p>
                    <p>Quantity: {{ $item->quantity }}</p>
                    <p>Price: ${{ number_format($item->price, 2) }}</p>
                    <p>Subtotal: ${{ number_format($item->price * $item->quantity, 2) }}</p>
                </div>
                @endforeach
                <div class="total">
                    <p>Total Amount: ${{ number_format($total, 2) }}</p>
                </div>
            </div>

            <p>Order Date: {{ now()->format('F j, Y H:i:s') }}</p>
            <p>Order ID: {{ $orderId }}</p>
        </div>
        <div class="footer">
            <p>Thank you for shopping with us!</p>
            <p>If you have any questions, please contact our support team.</p>
        </div>
    </div>
</body>
</html> 