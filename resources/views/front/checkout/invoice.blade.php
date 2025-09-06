{{-- resources/views/front/checkout/invoice.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice - {{ $order->invoice_no }}</title>
    <style>
        body {
           font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
            line-height: 1.5;
            font-size: 14px;
          
        }
        .invoice-box {
            
        }
        .invoice-boxone{

              /* This sets the background watermark image */
            background-image: url("{{ $watermarkPath }}");
            background-repeat: no-repeat;
            background-position: center;
            background-size: 50%;
        }

        
        .header { text-align: center; margin-bottom: 40px; }
        .header h1 { color: #333; margin: 0; padding-bottom: 5px; }
        .header img { width: 60px; height: 60px; margin-bottom: 10px; }
        .details { margin-bottom: 50px; }
        .details-table { width: 100%; }
        .details-table td { padding: 5px; vertical-align: top; }
        .from-to { font-size: 14px; }
        .from-to strong { display: block; margin-bottom: 5px; color: #333; }
        .invoice-details { text-align: left; }
        .invoice-details strong { display: block; }
        
        .items-table { width: 100%; line-height: inherit; text-align: left; border-collapse: collapse; }
        .items-table th { background: #eee; padding: 8px; font-weight: bold; text-align: left; }
        .items-table td { padding: 8px; border-bottom: 1px solid #eee; }
        .items-table .total td { border-bottom: none; }
        .summary-table { width: 100%; }
        .summary { float: right; width: 40%; text-align: right; }
        .summary td { padding: 5px; }
        .summary .total { font-weight: bold; font-size: 16px; color: #333; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="header">
            <img src="{{asset('/')}}public/front/assets/img/pick-logo.png" alt="Company Logo">
            <h1>Your Purchase Record</h1>
        </div>

    </div>
    <hr>
<div class="invoice-boxone">
        <table class="details-table">
            <tr style="margin-top: 20px;">
                <td class="invoice-details">
                    <h4>Invoice #{{ $order->invoice_no }}</h4>

                
                </td>
                <td style="text-align: right">
                      @if($order->payment_status == 'paid')
                      <div class="paid-status" style=" border: 2px solid #28a745;
            background: #28a745;
            color:white;
             padding: 3px 10px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 15px;"> <span>Paid</span></div>
                        @else

                        <div class="unpaid-status" style=" border: 2px solid #dc3545;
            background: #dc3545;
            color:white;
             padding: 3px 10px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 15px;"> <span>Unpaid</span></div>

                    @endif
                </td>
            </tr>
            <tr style="margin-top: 20px;">
                <td style="text-align: left;">  <strong>Issued On:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('F d, Y') }}</td>  
                 <td style="text-align: right;">    
                  
                    <strong>Due On:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('F d, Y') }}</td>    
            </tr>
            <tr style="margin-top: 20px;">
                <td class="from-to">
                    <strong>From</strong>
                    Pick N Drop<br>
                    Tera Maket, Siddhirganj, Narayanganj 1430.
                </td>
                <td class="from-to" style="text-align: right;">
                    <strong>To</strong>
                    {{ $order->customer->name }}<br>
                    {!! nl2br(e($order->shipping_address)) !!}
                </td>
            </tr>
        </table>
        
        <table class="items-table" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th>SI</th>
                    <th>Description</th>
                    <th style="text-align: center;">Quantity</th>
                    <th style="text-align: right;">Unit Price</th>
                    <th style="text-align: right;">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderDetails as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        {{ $item->product->name }}
                        @if($item->color) <small>(Color: {{ $item->color }})</small> @endif
                        @if($item->size) <small>(Size: {{ $item->size }})</small> @endif
                    </td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td style="text-align: right;">{{ number_format($item->unit_price, 2) }}</td>
                    <td style="text-align: right;">{{ number_format($item->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <br><br>

        <table class="summary-table">
            <tr>
                <td class="summary">
                    <table style="width: 100%;">
                        <tr>
                            <td>Subtotal</td>
                            <td>{{ number_format($order->subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Discount</td>
                            <td>{{ number_format($order->discount, 2) }}</td>
                        </tr>
                        <tr>
                    <td>Shipping Cost</td>
                    <td>{{ number_format($order->shipping_cost, 2) }}</td>
                </tr>
                        <tr>
                            <td><strong>Total</strong></td>
                            <td class="total"><strong>{{ number_format($order->total_amount, 2) }}</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Amount Due</strong></td>
                            <td><strong>{{ number_format($order->total_amount, 2) }}</strong></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
</div>
   
</body>
</html>