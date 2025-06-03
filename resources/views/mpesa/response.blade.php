<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Mpesa Transaction Response</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 2rem;
            background: #f9f9f9;
            color: #333;
        }
        .response-container {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
            max-width: 500px;
            margin: auto;
        }
        h1 {
            color: #007f3e;
        }
        .field {
            margin: 0.8rem 0;
        }
        .label {
            font-weight: 600;
            color: #555;
        }
        .value {
            font-size: 1.1rem;
            margin-left: 0.5rem;
            color: #111;
        }
    </style>
</head>
<body>
    <div class="response-container">
        <h1>Mpesa Transaction Response</h1>

        @if(isset($response['ResponseCode']))
            <div class="field">
                <span class="label">Response Code:</span>
                <span class="value">{{ $response['ResponseCode'] }}</span>
            </div>
        @endif

        @if(isset($response['ResponseDescription']))
            <div class="field">
                <span class="label">Description:</span>
                <span class="value">{{ $response['ResponseDescription'] }}</span>
            </div>
        @endif

        @if(isset($response['MerchantRequestID']))
            <div class="field">
                <span class="label">Merchant Request ID:</span>
                <span class="value">{{ $response['MerchantRequestID'] }}</span>
            </div>
        @endif

        @if(isset($response['CheckoutRequestID']))
            <div class="field">
                <span class="label">Checkout Request ID:</span>
                <span class="value">{{ $response['CheckoutRequestID'] }}</span>
            </div>
        @endif

        @if(isset($response['CustomerMessage']))
            <div class="field">
                <span class="label">Customer Message:</span>
                <span class="value">{{ $response['CustomerMessage'] }}</span>
            </div>
        @endif

        @if(empty($response))
            <p>Error: Unknown response from Mpesa.</p>
        @endif
    </div>
</body>
</html>
