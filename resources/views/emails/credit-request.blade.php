<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credit Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            background: #D4AF37;
            color: #2c1e1e;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
            margin: -20px -20px 20px -20px;
        }
        .amount {
            font-size: 24px;
            font-weight: bold;
            color: #D4AF37;
            text-align: center;
            margin: 20px 0;
        }
        .details {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            margin: 10px 5px;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .approve { background-color: #28a745; }
        .reject { background-color: #dc3545; }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Credit Request</h1>
        </div>

        <p>Hello,</p>
        
        <p>You have received a new credit request from a customer:</p>

        <div class="details">
            <p><strong>Customer:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Current Credit Balance:</strong> ${{ number_format($user->credit, 2) }}</p>
            <p><strong>Request ID:</strong> #{{ $requestId }}</p>
        </div>

        <div class="amount">
            Requested Amount: ${{ number_format($amount, 2) }}
        </div>

        @if($reason)
        <div class="details">
            <p><strong>Reason:</strong></p>
            <p>{{ $reason }}</p>
        </div>
        @endif        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ url('/admin/credit/approve?user_id=' . $user->id . '&amount=' . $amount . '&request_id=' . $requestId) }}" class="button approve">
                Approve Request
            </a>
            <a href="{{ url('/admin/credit/reject?request_id=' . $requestId) }}" class="button reject">
                Reject Request
            </a>
        </div>

        <div class="footer">
            <p>Please click on the buttons above to approve or reject this credit request.</p>
            <p>You can also manage credit requests from the admin panel.</p>
        </div>
    </div>
</body>
</html>
