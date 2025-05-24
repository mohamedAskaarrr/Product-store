<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refund Request</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; padding: 20px 0; background-color: #D4AF37; color: #2c1e1e; }
        .content { padding: 20px; background-color: #f9f9f9; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Refund Request</h1>
        </div>
        <div class="content">
            <p><strong>User:</strong> {{ $user->name }} ({{ $user->email }})</p>
            <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
            <p><strong>Order Total:</strong> ${{ number_format($order->total_price, 2) }}</p>
            <p><strong>Reason for Refund:</strong></p>
            <p>{{ $reason ? e($reason) : 'No reason provided.' }}</p>
            <div style="margin: 30px 0; text-align: center;">
                <a href="{{ url('/orders/' . $order->id . '/confirm-refund?token=' . urlencode($token)) }}" style="display: inline-block; background: #D4AF37; color: #2c1e1e; padding: 14px 32px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 18px; margin-top: 20px;">Confirm Refund</a>
            </div>
        </div>
        <div class="footer">
            <p>This is an automated notification from your store system.</p>
        </div>
    </div>
</body>
</html> 