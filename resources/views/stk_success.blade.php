<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BokinceX_Receipt_#{{ $order->id }}</title>
    <style>
        /* Professional thermal receipt typography */
        body { 
            background-color: #e0e0e0; 
            font-family: 'Courier New', Courier, monospace; 
            padding: 40px 15px; 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            color: #000;
        }

        .receipt-container { 
            background-color: white; 
            width: 80mm; 
            padding: 12mm 6mm; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.1); 
            box-sizing: border-box; 
            position: relative;
        }

        /* Thermal receipt "cut" effect */
        .receipt-container::after {
            content: "";
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 10px;
            background: linear-gradient(-135deg, white 5px, transparent 0) 0 5px, 
                        linear-gradient(135deg, white 5px, transparent 0) 0 5px;
            background-size: 10px 10px;
        }

        .text-center { text-align: center; }
        .dashed-line { border-top: 1px dashed #000; margin: 12px 0; }
        .bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }

        .items-table { 
            width: 100%; 
            font-size: 13px; 
            border-collapse: collapse; 
            margin: 15px 0;
        }

        /* Fit content strategy: Qty and Total stay on one line, Item name can wrap */
        .items-table th, .items-table td { 
            padding: 4px 0; 
            vertical-align: top;
        }

        .col-item { text-align: left; white-space: normal; word-break: break-word; }
        .col-qty { text-align: center; white-space: nowrap; width: 1%; padding: 4px 8px; }
        .col-total { text-align: right; white-space: nowrap; width: 1%; }

        .items-table th { 
            border-bottom: 1px solid #000; 
            font-size: 11px;
            text-transform: uppercase;
        }

        .total-section {
            font-size: 16px;
            margin-top: 15px;
            border-top: 2px solid #000;
            padding-top: 10px;
        }

        .status-badge {
            background: #000;
            color: #fff;
            padding: 3px 8px;
            font-size: 10px;
            display: inline-block;
            margin: 10px 0;
            letter-spacing: 1px;
        }

        .store-info {
            font-size: 10px;
            margin-top: 10px;
            line-height: 1.4;
        }

        .vat-info {
            font-size: 10px;
            border-top: 1px dashed #000;
            margin-top: 10px;
            padding-top: 5px;
        }

        .no-print { 
            margin-top: 30px; 
            display: flex; 
            gap: 15px; 
            font-family: sans-serif;
        }

        .btn { 
            padding: 12px 24px; 
            border: none; 
            border-radius: 8px; 
            cursor: pointer; 
            font-weight: 800; 
            text-decoration: none; 
            color: white; 
            transition: all 0.2s ease;
            text-transform: uppercase;
            font-size: 13px;
        }

        .btn-print { background: #1a1a1a; box-shadow: 0 4px 0 #000; }
        .btn-print:active { transform: translateY(2px); box-shadow: 0 2px 0 #000; }
        
        .btn-confirm { background: #007c00; box-shadow: 0 4px 0 #004d00; }
        .btn-confirm:active { transform: translateY(2px); box-shadow: 0 2px 0 #004d00; }

        @media print { 
            .no-print { display: none; } 
            body { background: white; padding: 0; } 
            .receipt-container { 
                width: 80mm; 
                box-shadow: none; 
                margin: 0; 
                padding: 5mm;
            } 
            .receipt-container::after { display: none; }
            .status-badge { background: #000 !important; color: #fff !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>

    <div class="receipt-container">
        <div class="text-center">
            <h1 style="margin: 0; font-size: 22px; letter-spacing: -1px;">BOKINCEX STORE</h1>
            <p style="margin: 5px 0; font-size: 12px; font-weight: bold;">*** OFFICIAL RECEIPT ***</p>
            <div class="dashed-line"></div>
        </div>

        @if($order->status === 'completed' || $order->status === 'Paid' || $order->status === 'paid')
            <div class="text-center">
                <span class="status-badge">✓ PAID</span>
            </div>
        @endif

        <div style="font-size: 12px; line-height: 1.6;">
            <p style="margin: 0;">TXN: <span class="bold">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span></p>
            <p style="margin: 0;">DATE: {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p style="margin: 0;">CUST: {{ $order->shipping_name ?? $order->name }}</p>
            <p style="margin: 0;">PHONE: {{ $order->contact_number }}</p>
        </div>
        
        <table class="items-table">
            <thead>
                <tr>
                    <th class="col-item">DESCRIPTION</th>
                    <th class="col-qty">QTY</th>
                    <th class="col-total">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td class="col-item uppercase">{{ $item->product->name }}</td>
                    <td class="col-qty">{{ $item->quantity }}</td>
                    <td class="col-total">KES {{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section text-center">
            <p class="bold uppercase" style="margin: 0;">TOTAL PAID</p>
            <p class="bold" style="font-size: 24px; margin: 5px 0;">KES {{ number_format($order->total_amount, 2) }}</p>
        </div>

        <div class="vat-info">
            <p style="margin: 0;">VAT INCLUDED @ 16%: KES {{ number_format($order->total_amount * 0.16, 2) }}</p>
        </div>

        <div class="dashed-line"></div>
        
        <div class="text-center" style="font-size: 11px; margin-top: 10px; line-height: 1.5;">
            <p>PAYMENT: <span class="bold">{{ strtoupper($order->payment_method) }}</span></p>
            
            <div class="store-info">
                <p style="margin: 2px 0;">Tel: 0712 345 678</p>
                <p style="margin: 2px 0;">Email: info@bokincex.co.ke</p>
            </div>
            
            <p style="margin-top: 10px; font-style: italic;">Thank you for your business!</p>
            <p class="bold" style="margin-top: 5px;">WWW.BOKINCEX.CO.KE</p>
        </div>
    </div>

    <div class="no-print">
        <button onclick="window.print()" class="btn btn-print">Print Receipt</button>
        <a href="{{ route('checkout.confirmation', ['order_id' => $order->id]) }}" class="btn btn-confirm">Finish & Confirm</a>
    </div>

    <script>
        // Auto-open print dialog after 1 second
        setTimeout(() => {
            window.print();
        }, 1000);
    </script>
</body>
</html>