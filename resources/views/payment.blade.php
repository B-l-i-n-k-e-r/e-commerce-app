<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>M-Pesa STK Push</title>
    <style>
        /* Reset some default styles */
        body, h2, p, ul, li, label, input, button {
            margin: 0; padding: 0; box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background: #f4f7f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            padding: 40px 15px;
        }
        .container {
            background: white;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 100%;
        }
        h2 {
            margin-bottom: 25px;
            text-align: center;
            color: #007c00; /* M-Pesa green */
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
        }
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 20px;
            border: 1.5px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        input[type="text"]:focus,
        input[type="number"]:focus {
            border-color: #007c00;
            outline: none;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #007c00;
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-weight: 700;
        }
        button:hover {
            background-color: #005f00;
        }
        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 6px;
            font-weight: 600;
            text-align: center;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1.5px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1.5px solid #f5c6cb;
        }
        ul {
            list-style-type: disc;
            padding-left: 20px;
        }
        @media (max-width: 480px) {
            .container {
                padding: 20px 25px;
            }
            button {
                font-size: 16px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>M-Pesa Payment</h2>

        @if (session('success'))
            <p class="message success">{{ session('success') }}</p>
        @elseif (session('error'))
            <p class="message error">{{ session('error') }}</p>
        @endif

        @if ($errors->any())
            <div class="message error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('stkpush') }}">
            @csrf

            <label for="phone">Phone Number (format 2547...):</label>
            <input type="text" id="phone" name="phone" required value="{{ old('phone') }}" placeholder="e.g. 254712345678" />

            <label for="amount">Amount (KES):</label>
            <input type="number" id="amount" name="amount" required min="1" value="{{ old('amount') }}" placeholder="Enter amount to pay" />

            <button type="submit">Pay with M-PESA</button>
        </form>
    </div>
</body>
</html>

