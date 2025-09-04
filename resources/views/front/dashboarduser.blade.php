@extends('front.master.master')
@section('title')
Dashboard
@endsection

@section('css')
<style>
/* Custom styles for tracking progress bar */
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
                <h2 class="page-hero-title">Personal Hub</h2>
                <div class="page-hero-nav-links bg-white rounded">
                    <a href="{{ route('home.index') }}">Home</a> - <a class="fw-bold" href="#">Identity Page</a>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="profile-container-fluid overflow-hidden py-4">
    <!-- Navigation Tabs -->
    <div class="row">
        <div class="col-12">
            <ul class="nav nav-tabs profile-custom-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link profile-nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">
                        Overview
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link profile-nav-link" id="order-tracking-tab" data-bs-toggle="tab" data-bs-target="#order-tracking" type="button" role="tab">
                        Order Tracking
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link profile-nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings" type="button" role="tab">
                        Edit Profile
                    </button>
                </li>
                <li class="nav-item ms-auto" role="presentation">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="nav-link profile-nav-link text-danger" type="submit">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="tab-content" id="myTabContent">
        <!-- Overview Tab -->
        <div class="tab-pane fade show active" id="overview" role="tabpanel">
           <div class="overflow-hidden">
                <div class="row">
                    <!-- Left Sidebar -->
                    <div class="col-lg-3 col-md-4 mb-4 border-end pe-0">
                        <!-- Profile Section -->
                        <div class="profile-card my-md-4">
                            <div class="profile-header d-flex align-items-start mb-3">
                                <div class="profile-img-avatar me-3">
                                    <img style="width:50px;" src="{{ $user->image ? asset('public/'.$user->image) : 'https://placehold.co/100x100?text=Avatar' }}" alt="User Avatar">
                                </div>
                                <div>
                                    <h5 class="mb-0 profile-name fw-bold">{{ $user->name }}</h5>
                                    <small class="text-muted">#CUST-{{ $user->customer_id ?? 'N/A' }}</small>
                                </div>
                            </div>
                        </div>

                        <!-- About Section -->
                        <div class="profile-info-section mb-md-4">
                            <h6 class="profile-section-title">About</h6>
                            <div class="profile-info-item">
                                <span class="span-1"><i class="fas fa-phone me-2 pe-1"></i>Phone: </span>
                                <span class="ps-1 span-2">{{ $user->phone ?? 'Not Set' }}</span>
                            </div>
                            <div class="profile-info-item">
                                <span class="span-1"><i class="fas fa-envelope pe-2"></i>Email: </span>
                                <span class="ps-1 span-2">{{ $user->email }}</span>
                            </div>
                        </div>

                        <!-- Billing Address -->
                        <div class="profile-info-section mb-md-4">
                            <h6 class="profile-section-title">Billing Address</h6>
                            <div class="profile-info-item">
                                <span class="span-1"><i class="fas fa-map-marker-alt pe-1"></i>Address: </span>
                                <span class="ps-1 span-2">{{ $billingAddress->address ?? 'Not Set' }}</span>
                            </div>
                        </div>

                        <!-- Shipping Address -->
                        <div class="profile-info-section">
                            <h6 class="profile-section-title">Shipping Address</h6>
                            <div class="profile-info-item">
                                <span class="span-1"><i class="fas fa-map-marker-alt pe-1"></i>Address: </span>
                                <span class="ps-1 span-2">{{ $shippingAddress->address ?? 'Not Set' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Content -->
                    <div class="col-lg-9 col-md-8">
                        <!-- Recent Orders -->
                        <div class="profile-table-section mb-5 pt-3 ps-2">
                            <h5 class="profile-section-title mb-mb-4">Recent Orders</h5>
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
                                    <tbody>
                                        @forelse($recentOrders as $order)
                                        <tr>
                                            <td>#{{ $order->invoice_no }}</td>
                                            <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</td>
                                            <td><span class="profile-badge {{ $order->payment_status == 'paid' ? 'success-bg' : 'danger-bg' }}">{{ ucfirst($order->payment_status) }}</span></td>
                                            <td>৳ {{ number_format($order->total_amount, 2) }}</td>
                                            <td>{{ $order->order_details_count }}</td>
                                            <td><span class="profile-badge info-bg">{{ ucfirst($order->status) }}</span></td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center">You have no recent orders.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Cancel Orders -->
                        <div class="profile-table-section ps-2">
                            <h5 class="profile-section-title mb-md-4">Cancel Orders</h5>
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
                                    <tbody>
                                        @forelse($cancelOrders as $order)
                                        <tr>
                                            <td>#{{ $order->invoice_no }}</td>
                                            <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</td>
                                            <td><span class="profile-badge {{ $order->payment_status == 'paid' ? 'success-bg' : 'danger-bg' }}">{{ ucfirst($order->payment_status) }}</span></td>
                                            <td>৳ {{ number_format($order->total_amount, 2) }}</td>
                                            <td>{{ $order->order_details_count }}</td>
                                            <td><span class="profile-badge warning-bg">{{ ucfirst($order->status) }}</span></td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center">You have no cancelled orders.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Tracking Tab -->
        <div class="tab-pane fade" id="order-tracking" role="tabpanel">
            <div class="pick-order-tracking overflow-hidden mt-5">
                <!-- Search Section -->
                <div class="d-flex w-50 gap-2 justify-content-center m-auto order-track-input mb-3">
                    <input type="text" class="form-control" placeholder="Enter Order Number" id="trackOrderInput">
                    <button class="btn px-4" type="button" id="trackOrderBtn">Track Order</button>
                </div>
                <div id="tracking-error" class="text-center text-danger my-3" style="display: none;"></div>


                <!-- Dynamic Order Detail Section -->
                <div id="tracking-results" style="display: none;">
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

                    <!-- Dynamic Track Order Progress -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <h6 class="mb-4 track-order">Track Order</h6>
                            <div class="order-tracking-progress-container" id="tracking-progress-bar">
                                <!-- Progress steps will be injected here by JavaScript -->
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Orders Table -->
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
                                            <!-- Order row will be injected here by JavaScript -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Tab (Edit Profile) -->
        <div class="tab-pane fade" id="settings" role="tabpanel">
           <div class="overflow-hidden">
                <div class="row g-4">
                    <!-- Left Column - Manage Personal Information -->
                    <div class="col-lg-6 border-end pe-md-0">
                        <div class="manage-personal-info-card">
                            <h4 class="manage-personal-info-title py-4 border-bottom">Manage Personal Information</h4>

                            @if (session('status'))
                                <div class="alert alert-success my-3">{{ session('status') }}</div>
                            @endif

                            <form action="{{ route('dashboard.profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!-- Profile Image Upload -->
                                <div class="manage-personal-info-profile-section gap-2 pe-md-5 mb-4">
                                    <div class="manage-personal-info-profile-container">
                                        <div class="manage-personal-info-profile-image">
                                            <img src="{{ $user->image ? asset('public/'.$user->image) : 'https://placehold.co/100x100?text=Avatar' }}" alt="Profile" id="profileImage">
                                            <div class="manage-personal-info-profile-overlay">
                                                <i class="fas fa-camera"></i>
                                            </div>
                                            <input type="file" name="profile_image" id="imageUpload" accept="image/*" style="display: none;">
                                        </div>
                                    </div>
                                    <div class="w-100">
                                        <div class="manage-personal-info-phone mb-3">
                                            <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" placeholder="Enter full name">
                                            @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="manage-personal-info-phone">
                                            <input type="text" class="form-control pnr" value="#CUST-{{ $user->customer_id ?? 'N/A' }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <!-- About Section -->
                                <div class="manage-personal-info-section mb-4">
                                    <h6 class="manage-personal-info-section-title border-bottom pb-3">About</h6>
                                    <div class="pe-md-5">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <input type="text" class="form-control manage-personal-info-input" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Enter Phone Number">
                                                @error('phone')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="col-12">
                                                <input type="email" class="form-control manage-personal-info-input" value="{{ $user->email }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Billing Address Section -->
                                <div class="manage-personal-info-section mb-4">
                                    <h6 class="manage-personal-info-section-title border-bottom pb-3">Billing Address</h6>
                                    <div class="pe-md-5">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <input type="text" class="form-control manage-personal-info-input" name="billing_address" value="{{ old('billing_address', $billingAddress->address ?? '') }}" placeholder="Billing Address">
                                                 @error('billing_address')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Shipping Address Section -->
                                <div class="manage-personal-info-section mb-4">
                                    <h6 class="manage-personal-info-section-title border-bottom pb-3">Shipping Address</h6>
                                    <div class="pe-md-5">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <input type="text" class="form-control manage-personal-info-input" name="shipping_address" value="{{ old('shipping_address', $shippingAddress->address ?? '') }}" placeholder="Shipping Address">
                                                @error('shipping_address')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="pe-md-5 mt-4">
                                     <button type="submit" class="btn btn-primary access-now-btn">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Right Column - Authentication Settings -->
                    <div class="col-lg-6 ps-lg-0">
                        <div class="manage-personal-info-card">
                            <h4 class="manage-personal-info-title py-4 border-bottom ps-5">Authentication Settings</h4>
                            
                             @if (session('password_status'))
                                <div class="alert alert-success my-3 mx-lg-5">{{ session('password_status') }}</div>
                            @endif
                             @if ($errors->has('old_password'))
                                <div class="alert alert-danger my-3 mx-lg-5">{{ $errors->first('old_password') }}</div>
                            @endif

                            <form action="{{ route('dashboard.password.update') }}" method="POST">
                                @csrf
                                <div class="password-container ps-lg-5 pt-md-5">
                                    <!-- Old Password Field -->
                                    <div class="form-group">
                                        <div class="password-field">
                                            <div class="input-group">
                                                <input class="form-control manage-personal-info-input" type="password" name="old_password" placeholder="Enter your old password" required>
                                                <span class="input-group-text toggle-password"><i class="fas fa-eye"></i></span>
                                            </div>
                                            @error('old_password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                        </div>
                                    </div>

                                    <!-- New Password Field -->
                                    <div class="form-group">
                                        <div class="password-field">
                                            <div class="input-group">
                                                <input class="form-control manage-personal-info-input" type="password" name="password" id="dashboardNewPassword" placeholder="Create new password" required>
                                                <span class="input-group-text toggle-password"><i class="fas fa-eye"></i></span>
                                            </div>
                                            @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="password-field">
                                            <div class="input-group">
                                                <input class="form-control manage-personal-info-input" type="password" name="password_confirmation" id="dashboardConfirmPassword" placeholder="Confirm your new password" required>
                                                <span class="input-group-text toggle-password"><i class="fas fa-eye"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Password Match Error -->
                                    <div class="match-error small text-danger mt-1" id="dashboardPasswordMatchError" style="display: none;">
                                        Passwords do not match
                                    </div>

                                    <!-- Password Strength Indicator -->
                                    <div class="strength-container">
                                        <div class="strength-bars">
                                            <div class="strength-bar" id="bar1"></div>
                                            <div class="strength-bar" id="bar2"></div>
                                            <div class="strength-bar" id="bar3"></div>
                                            <div class="strength-bar" id="bar4"></div>
                                        </div>
                                        <div class="strength-label-container">
                                            <span class="strength-label" id="current-strength-label"></span>
                                        </div>
                                    </div>
                                    
                                    <!-- Password Requirements -->
                                    <div class="requirements small mt-2">
                                        <div class="requirement" id="dash-req-lower"><i class="fas fa-times text-danger"></i><span>At least one lowercase letter</span></div>
                                        <div class="requirement" id="dash-req-length"><i class="fas fa-times text-danger"></i><span>Minimum 8 characters</span></div>
                                        <div class="requirement" id="dash-req-upper"><i class="fas fa-times text-danger"></i><span>At least one uppercase letter</span></div>
                                        <div class="requirement" id="dash-req-number"><i class="fas fa-times text-danger"></i><span>At least one number</span></div>
                                    </div>

                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-primary access-now-btn">Change Password</button>
                                    </div>
                                </div>
                            </form>

                            {{-- Goodbye Section --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
{{-- Script for Order Tracking --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const trackOrderBtn = document.getElementById('trackOrderBtn');
    const trackOrderInput = document.getElementById('trackOrderInput');
    const trackingResults = document.getElementById('tracking-results');
    const trackingError = document.getElementById('tracking-error');

    if(trackOrderBtn) {
        trackOrderBtn.addEventListener('click', function () {
            const invoiceNo = trackOrderInput.value.trim();
            if (!invoiceNo) {
                trackingError.textContent = 'Please enter an order number.';
                trackingError.style.display = 'block';
                return;
            }

            // Reset UI
            trackingResults.style.display = 'none';
            trackingError.style.display = 'none';
            trackOrderBtn.disabled = true;
            trackOrderBtn.textContent = 'Tracking...';

            fetch("{{ route('track.order') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ invoice_no: invoiceNo })
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    trackingError.textContent = data.error;
                    trackingError.style.display = 'block';
                } else {
                    displayTrackingInfo(data);
                    trackingResults.style.display = 'block';
                }
            })
            .catch(err => {
                console.error('Tracking Error:', err);
                trackingError.textContent = 'An unexpected error occurred. Please try again.';
                trackingError.style.display = 'block';
            })
            .finally(() => {
                trackOrderBtn.disabled = false;
                trackOrderBtn.textContent = 'Track Order';
            });
        });
    }

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
        if(order.status === 'cancel') progressBar.parentElement.parentElement.classList.add('cancelled');
        else progressBar.parentElement.parentElement.classList.remove('cancelled');

        // --- 3. Update Table ---
        const tableBody = document.getElementById('tracking-table-body');
        const paymentStatusClass = order.payment_status === 'paid' ? 'success-bg' : 'danger-bg';
        const orderStatusClass = order.status === 'delivered' ? 'success-bg' : 'orange-bg';
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

{{-- Script for Profile Image Preview --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const imageUpload = document.getElementById('imageUpload');
    const profileImage = document.getElementById('profileImage');
    const profileOverlay = document.querySelector('.manage-personal-info-profile-overlay');

    if (profileOverlay) {
        profileOverlay.addEventListener('click', () => imageUpload.click());
    }

    if (imageUpload) {
        imageUpload.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    profileImage.setAttribute('src', e.target.result);
                }
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const heroTitle = document.querySelector('.page-hero-title');
    const heroBreadcrumb = document.querySelector('.page-hero-nav-links .fw-bold');

    const overviewTab = document.getElementById('overview-tab');
    const trackingTab = document.getElementById('order-tracking-tab');
    const settingsTab = document.getElementById('settings-tab');

    const tabInfo = {
        overview: {
            title: 'Personal Hub',
            breadcrumb: 'Identity Page'
        },
        tracking: {
            title: 'Track it Live',
            breadcrumb: 'Your Delivery Timeline'
        },
        settings: {
            title: 'Customize Your Experience',
            breadcrumb: 'Your Preferences'
        }
    };

    function updateHeroContent(tabKey) {
        if (heroTitle && heroBreadcrumb && tabInfo[tabKey]) {
            heroTitle.textContent = tabInfo[tabKey].title;
            heroBreadcrumb.textContent = tabInfo[tabKey].breadcrumb;
        }
    }

    if (overviewTab) {
        overviewTab.addEventListener('click', () => updateHeroContent('overview'));
    }
    if (trackingTab) {
        trackingTab.addEventListener('click', () => updateHeroContent('tracking'));
    }
    if (settingsTab) {
        settingsTab.addEventListener('click', () => updateHeroContent('settings'));
    }
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const passwordContainer = document.querySelector('.password-container');
    if (!passwordContainer) return;

    const newPasswordInput = document.getElementById('dashboardNewPassword');
    const confirmPasswordInput = document.getElementById('dashboardConfirmPassword');
    const matchError = document.getElementById('dashboardPasswordMatchError');
    const togglePasswordIcons = passwordContainer.querySelectorAll('.toggle-password');

    const requirements = {
        lower: document.getElementById('dash-req-lower'),
        length: document.getElementById('dash-req-length'),
        upper: document.getElementById('dash-req-upper'),
        number: document.getElementById('dash-req-number')
    };

    const strength = {
        bars: passwordContainer.querySelectorAll('.strength-bar'),
        label: document.getElementById('current-strength-label')
    };

    const strengthLevels = {
        0: { label: '', color: '' },
        1: { label: 'Weak', color: 'weak' },
        2: { label: 'Medium', color: 'medium' },
        3: { label: 'Strong', color: 'strong' },
        4: { label: 'Very Strong', color: 'very-strong' }
    };

    // --- Show/Hide Password Functionality ---
    togglePasswordIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    });

    // --- Live Password Validation ---
    if (newPasswordInput) {
        const validateRequirement = (element, isValid) => {
            if (!element) return;
            const icon = element.querySelector('i');
            if (isValid) {
                icon.classList.remove('fa-times', 'text-danger');
                icon.classList.add('fa-check', 'text-success');
            } else {
                icon.classList.remove('fa-check', 'text-success');
                icon.classList.add('fa-times', 'text-danger');
            }
        };

        const checkPasswordStrength = (password) => {
            let score = 0;
            if (/[a-z]/.test(password)) score++;
            if (/[A-Z]/.test(password)) score++;
            if (/[0-9]/.test(password)) score++;
            if (password.length >= 8) score++;
            
            strength.bars.forEach((bar, index) => {
                bar.className = 'strength-bar'; // Reset
                if (index < score) {
                    bar.classList.add(strengthLevels[score].color);
                }
            });
            strength.label.textContent = strengthLevels[score].label;
        };

        const checkPasswords = () => {
            const password = newPasswordInput.value;
            // Requirement validation
            validateRequirement(requirements.lower, /[a-z]/.test(password));
            validateRequirement(requirements.length, password.length >= 8);
            validateRequirement(requirements.upper, /[A-Z]/.test(password));
            validateRequirement(requirements.number, /[0-9]/.test(password));
            
            // Strength validation
            checkPasswordStrength(password);
            
            // Match validation
            if (confirmPasswordInput.value && password !== confirmPasswordInput.value) {
                matchError.style.display = 'block';
            } else {
                matchError.style.display = 'none';
            }
        };

        newPasswordInput.addEventListener('keyup', checkPasswords);
        confirmPasswordInput.addEventListener('keyup', checkPasswords);
    }
});
</script>
@endsection

