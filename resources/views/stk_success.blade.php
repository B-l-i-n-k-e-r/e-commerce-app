<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STK Push Processing</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 40px 0;
            display: flex;
            justify-content: center;
        }

        .container {
            background-color: white;
            border-radius: 12px;
            padding: 30px;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        h1 {
            color: #fd7e14;
            font-size: 24px;
            margin-bottom: 10px;
            text-align: center;
        }

        p {
            margin: 8px 0;
            line-height: 1.5;
        }

        .manual-confirmation {
            margin-top: 25px;
            border: 1px dashed #aaa;
            padding: 20px;
            border-radius: 8px;
            background-color: #fcfcfc;
        }

        .manual-confirmation h2 {
            margin-top: 0;
            color: #333;
        }

        textarea {
            width: 100%;
            padding: 12px;
            font-size: 14px;
            border-radius: 8px;
            border: 1px solid #ccc;
            margin-top: 10px;
            resize: none;
            box-sizing: border-box;
        }

        button {
            margin-top: 15px;
            padding: 12px 20px;
            font-weight: bold;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #218838;
        }

        .transaction-info {
            margin-top: 25px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border-left: 5px solid #007bff;
        }

        .transaction-info p {
            margin: 5px 0;
        }

        strong {
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Transaction Processing...</h1>
        <p style="text-align: center;">A request has been sent to your phone. Please enter your M-Pesa PIN.</p>

        <div class="manual-confirmation">
            <h2>Enter M-Pesa Confirmation Message</h2>
            <!-- Wrap textarea and button in a form -->
            <form method="POST" action="{{ route('confirm.transaction') }}">
    @csrf
    <textarea name="mpesaMessage" rows="4" placeholder="Paste M-Pesa confirmation message here" required>{{ old('mpesaMessage') }}</textarea>
    @error('mpesaMessage')
        <div style="color: red;">{{ $message }}</div>
    @enderror
    <button type="submit">Submit Confirmation</button>
</form>

        </div>
    </div>
</body>
</html>
