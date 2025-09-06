{{-- resources/views/front/partials/order_details_modal_content.blade.php --}}

<div class="container-fluid">
    {{-- Order Summary --}}
    <div class="row mb-3">
        <div class="col-md-6">
            <strong>Order #:</strong > {{ $order->invoice_no }}
        </div>
        <div class="col-md-6 text-md-end">
            <strong>Date:</strong > {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <strong>Status:</strong> <span class="text-capitalize">{{ $order->status }}</span>
        </div>
        <div class="col-md-6 text-md-end">
             <strong>Payment:</strong> <span class="text-capitalize">{{ $order->payment_status }} ({{ strtoupper($order->payment_method) }})</span>
        </div>
    </div>
    <hr>
    {{-- Shipping & Billing --}}
     <div class="row mb-3">
        <div class="col-md-6">
            <h6>Shipping Address</h6>
            <address>
                {{ $order->shipping_address ?? 'N/A' }}
            </address>
        </div>
        <div class="col-md-6">
            <h6>Billing Address</h6>
             <address>
                {{ $order->billing_address ?? 'N/A' }}
            </address>
        </div>
    </div>
    <hr>
    {{-- Order Items Table --}}
    <h6>Order Items</h6>
    <div class="table-responsive">
        <table class="table table-sm table-striped">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Color/Size</th>
                    <th class="text-center">Qty</th>
                    <th class="text-end">Unit Price</th>
                    <th class="text-end">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderDetails as $item)
                <tr>
                    <td>{{ $item->product->name ?? 'Product not found' }}</td>
                    <td>{{ $item->color ?? '' }}/{{ $item->size ?? '' }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-end">৳{{ number_format($item->unit_price, 2) }}</td>
                    <td class="text-end">৳{{ number_format($item->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                 <tr>
                    <td colspan="4" class="text-end">Subtotal</td>
                    <td class="text-end">৳{{ number_format($order->subtotal, 2) }}</td>
                </tr>
                 <tr>
                    <td colspan="4" class="text-end">Shipping Cost</td>
                    <td class="text-end">৳{{ number_format($order->shipping_cost, 2) }}</td>
                </tr>
                 <tr>
                    <td colspan="4" class="text-end">Discount</td>
                    <td class="text-end">- ৳{{ number_format($order->discount, 2) }}</td>
                </tr>
                 <tr>
                    <td colspan="4" class="text-end fw-bold">Total</td>
                    <td class="text-end fw-bold">৳{{ number_format($order->total_amount, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>