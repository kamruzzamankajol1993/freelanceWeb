@extends('front.master.master')
@section('title')
Order Tracking
@endsection

@section('css')
<style>
/* Custom styles for tracking progress bar feedback */
.order-tracking-progress-step.danger .order-tracking-step-circle {
    background-color: #dc3545;
    border-color: #dc3545;
}
.order-tracking-progress-container.cancelled .order-tracking-progress-step:not(:first-child) {
    display: none;
}
.order-tracking-progress-container.cancelled .order-tracking-progress-step.danger::after {
    display: none;
}
</style>
@endsection

@section('body')
 <!-- Hero Section -->
    <section class="page-hero-section px-md-0 px-3">
      <div class="container">
        <div class="row">
          <div class="col-12 text-center">
            <h2 class="page-hero-title">Track it Live</h2>
            <div class="page-hero-nav-links bg-white rounded">
              <a href="{{ route('home.index') }}">Home</a> - <a class="fw-bold" href="#">Your Delivery Timeline</a>
            </div>
          </div>
        </div>
      </div>
    </section>


   <div class="pick-order-tracking overflow-hidden mt-5 pt-3 px-md-0 px-3">
     <!-- Search Section -->
     <div class="row mb-4">
       <div class="col-12">
         <div class="d-flex w-50 gap-2 justify-content-center m-auto order-track-input mb-3">
           <input type="text" class="form-control" placeholder="Enter Order Number" id="orderInput">
           <button class="btn px-4" type="button" id="trackOrderBtn">Track Order</button>
         </div>
         <div id="tracking-error" class="text-center text-danger mt-2"></div>
       </div>
     </div>

    <!-- Dynamic Results Container -->
    <div id="tracking-results" style="display: none;">
         <!-- Order Detail Section -->
         <div class="row mb-4">
           <div class="col-12">
             <div class="card border-0">
               <div class="card-body p-0">
                 <div class="d-flex justify-content-between align-items-start mb-3">
                   <div>
                     <h5 class="mb-1 tracing-headline">Order Detail</h5>
                     <small class="text-muted">Order Number: <span id="track-invoice-no"></span></small>
                   </div>
                   <div class="text-end end-transit">
                     <span class="badge text-dark px-3 py-2" id="track-status-badge"></span>
                     <div class="mt-1">
                       <small class="text-muted">Order Date: <span id="track-order-date"></span></small>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
           </div>
         </div>

         <!-- Track Order Progress -->
         <div class="row mb-5">
           <div class="col-12">
             <h6 class="mb-4 track-order">Track Order</h6>
             <div class="order-tracking-progress-container" id="tracking-progress-bar">
                <!-- Progress steps will be dynamically injected here -->
             </div>
           </div>
         </div>

         <!-- Orders Table -->
         <div class="row">
           <div class="col-12">
             <div class="profile-table-section mb-5 pt-3 ps-2">
               <div class="profile-table-responsive">
                 <table class="table table-hover profile-custom-table">
                   <thead>
                     <tr>
                       <th>Order No.</th>
                       <th>Purchase Date</th>
                       <th>Payment Status</th>
                       <th>Price</th>
                       <th>Item Qty.</th>
                       <th>Order Status</th>
                     </tr>
                   </thead>
                   <tbody id="tracking-table-body">
                     <!-- Order row will be dynamically injected here -->
                   </tbody>
                 </table>
               </div>
             </div>
           </div>
         </div>
    </div>
   </div>
@endsection


@section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const trackOrderBtn = document.getElementById('trackOrderBtn');
    const orderInput = document.getElementById('orderInput');
    const trackingResults = document.getElementById('tracking-results');
    const trackingError = document.getElementById('tracking-error');

    trackOrderBtn.addEventListener('click', function () {
        const invoiceNo = orderInput.value.trim();
        if (!invoiceNo) {
            trackingError.textContent = 'Please enter an order number.';
            return;
        }

        // Reset UI
        trackingResults.style.display = 'none';
        trackingError.textContent = '';
        trackOrderBtn.disabled = true;
        trackOrderBtn.textContent = 'Tracking...';

        fetch("{{ route('tracking.track') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ invoice_no: invoiceNo })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            displayTrackingInfo(data);
            trackingResults.style.display = 'block';
        })
        .catch(err => {
            trackingError.textContent = err.error || 'An unexpected error occurred.';
        })
        .finally(() => {
            trackOrderBtn.disabled = false;
            trackOrderBtn.textContent = 'Track Order';
        });
    });

    function displayTrackingInfo(order) {
        // --- 1. Update Header Details ---
        document.getElementById('track-invoice-no').textContent = '#' + order.invoice_no;
        document.getElementById('track-status-badge').textContent = order.status.charAt(0).toUpperCase() + order.status.slice(1);
        document.getElementById('track-order-date').textContent = order.formatted_created_at;

        // --- 2. Update Progress Bar ---
        const progressBar = document.getElementById('tracking-progress-bar');
        const statuses = ['pending', 'processing', 'shipped', 'in_transit', 'delivered'];
        const statusLabels = {
            pending: 'Order Received',
            processing: 'Generate Order',
            shipped: 'Transmitted To Courier',
            in_transit: 'Order Picked',
            delivered: 'Order Delivered'
        };
        let currentStatusIndex = statuses.indexOf(order.status);
        let html = '';

        statuses.forEach((status, index) => {
            let stepClass = '';
            if (index < currentStatusIndex) {
                stepClass = 'completed';
            } else if (index === currentStatusIndex) {
                stepClass = 'current';
            }

            if (order.status === 'cancel') {
                 if (index === 0) {
                     html += `<div class="order-tracking-progress-step completed danger">
                                <div class="order-tracking-step-circle"></div>
                                <div class="order-tracking-step-content">
                                    <div class="order-tracking-step-title">Order Cancelled</div>
                                    <div class="order-tracking-step-date">${order.formatted_created_at}</div>
                                </div>
                            </div>`;
                }
            } else {
                 html += `<div class="order-tracking-progress-step ${stepClass}">
                            <div class="order-tracking-step-circle"></div>
                            <div class="order-tracking-step-content">
                                <div class="order-tracking-step-title">${statusLabels[status]}</div>
                                <div class="order-tracking-step-date">${order.formatted_created_at}</div>
                            </div>
                        </div>`;
            }
        });
        progressBar.innerHTML = html;
        if(order.status === 'cancel') progressBar.classList.add('cancelled');
        else progressBar.classList.remove('cancelled');

        // --- 3. Update Table ---
        const tableBody = document.getElementById('tracking-table-body');
        const paymentStatusClass = order.payment_status === 'paid' ? 'success-bg' : 'danger-bg';
        const orderStatusClass = order.status === 'delivered' ? 'success-bg' : (order.status === 'cancel' ? 'warning-bg' : 'orange-bg');
        tableBody.innerHTML = `
            <tr>
                <td>#${order.invoice_no}</td>
                <td>${order.formatted_created_at}</td>
                <td><span class="profile-badge ${paymentStatusClass}">${order.payment_status.charAt(0).toUpperCase() + order.payment_status.slice(1)}</span></td>
                <td>৳ ${parseFloat(order.total_amount).toFixed(2)}</td>
                <td>${order.order_details_count}</td>
                <td><span class="profile-badge ${orderStatusClass}">${order.status.charAt(0).toUpperCase() + order.status.slice(1)}</span></td>
            </tr>
        `;
    }
});
</script>
@endsection
