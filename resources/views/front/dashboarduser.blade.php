@extends('front.master.master')
@section('title')
Dashboard
@endsection

@section('css')
<style>

    .order-tracking-progress-step.current .order-tracking-step-circle {
    background-color: #000;
    border-color: #000;
}

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
          @include('front.partials.dashabout')
        </div>

        <!-- Order Tracking Tab -->
        <div class="tab-pane fade" id="order-tracking" role="tabpanel">
     <div class="pick-order-tracking overflow-hidden mt-5">
            <!-- Search Section -->
            <div class="d-flex w-50 gap-2 justify-content-center m-auto order-track-input mb-3">
              <input type="text" class="form-control" placeholder="Enter Order Number" id="invoice-no-input">
              <button class="btn px-4" type="button" id="track-order-btn">Track Order</button>
            </div>
      

        <div id="tracking-loader" class="text-center my-5" style="display: none;">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <div id="tracking-error" class="alert alert-danger text-center my-4" style="display: none;"></div>

        <div id="tracking-results-container" style="display: none;">

            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0">
                        <div class="card-body p-0">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="mb-1 tracing-headline">Order Details</h5>
                                    <small class="text-muted">Order Number: <span id="tracking-invoice-no" class="fw-bold"></span></small>
                                </div>
                                <div class="text-end end-transit">
                                    <span id="tracking-status-badge" class="badge text-dark px-3 py-2 text-capitalize"></span>
                                    <div class="mt-1">
                                        <small class="text-muted">Order Date: <span id="tracking-order-date"></span></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-12">
                    <h6 class="mb-4 track-order">Track Order</h6>
                    <div id="progress-bar-container" class="order-tracking-progress-container">
                        <div class="order-tracking-progress-step" data-status="pending">
                            <div class="order-tracking-step-circle"></div>
                            <div class="order-tracking-step-content">
                                <div class="order-tracking-step-title">Pending</div>
                                <div class="order-tracking-step-date"></div>
                            </div>
                        </div>
                        <div class="order-tracking-progress-step" data-status="waiting">
                            <div class="order-tracking-step-circle"></div>
                            <div class="order-tracking-step-content">
                                <div class="order-tracking-step-title">Waiting</div>
                                <div class="order-tracking-step-date"></div>
                            </div>
                        </div>
                        <div class="order-tracking-progress-step" data-status="ready to ship">
                            <div class="order-tracking-step-circle"></div>
                            <div class="order-tracking-step-content">
                                <div class="order-tracking-step-title">Ready to Ship</div>
                                <div class="order-tracking-step-date"></div>
                            </div>
                        </div>
                        <div class="order-tracking-progress-step" data-status="shipping">
                            <div class="order-tracking-step-circle"></div>
                            <div class="order-tracking-step-content">
                                <div class="order-tracking-step-title">Shipping</div>
                                <div class="order-tracking-step-date"></div>
                            </div>
                        </div>
                        <div class="order-tracking-progress-step" data-status="delivered">
                            <div class="order-tracking-step-circle"></div>
                            <div class="order-tracking-step-content">
                                <div class="order-tracking-step-title">Delivered</div>
                                <div class="order-tracking-step-date"></div>
                            </div>
                        </div>
                        <div class="order-tracking-progress-step d-none" data-status="cancelled">
                             <div class="order-tracking-step-circle"></div>
                             <div class="order-tracking-step-content">
                                 <div class="order-tracking-step-title">Cancelled</div>
                                 <div class="order-tracking-step-date"></div>
                             </div>
                         </div>
                         <div class="order-tracking-progress-step d-none" data-status="failed to delivery">
                             <div class="order-tracking-step-circle"></div>
                             <div class="order-tracking-step-content">
                                 <div class="order-tracking-step-title">Failed to Deliver</div>
                                 <div class="order-tracking-step-date"></div>
                             </div>
                         </div>
                    </div>
                </div>
            </div>
<div class="row">
        <div class="col-12">
            <h6 class="mb-3 track-order">Order Items</h6>
            <div class="profile-table-section mb-5 pt-3 ps-2">
                <div class="profile-table-responsive">
                    <table class="table table-hover profile-custom-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Payment Status</th>
                            </tr>
                        </thead>
                        <tbody id="order-items-tbody">
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
            <div class="row">
                <div class="col-12">
                    <h6 class="mb-3 track-order">Tracking History</h6>
                    <div class="profile-table-section mb-5 pt-3 ps-2">
                        <div class="profile-table-responsive">
                            <table class="table table-hover profile-custom-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="tracking-history-tbody">
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
        @include('front.partials.dashedit')
    </div>
</div>
@endsection

@section('script')


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
{{-- Script for Account Deactivation/Deletion --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const deactivateForm = document.getElementById('deactivateForm');
    const deleteForm = document.getElementById('deleteForm');
    const errorDiv = document.getElementById('goodbye-error');

    if (deactivateForm) {
        deactivateForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = document.getElementById('deactivateBtn');
            const originalText = btn.innerHTML;
            
            btn.disabled = true;
            btn.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Processing...`;
            errorDiv.textContent = '';

            const formData = new FormData(this);

            fetch("{{ route('account.deactivate') }}", {
                method: 'POST',
                body: formData,
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': formData.get('_token') }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    toastr.info(data.message);
                    // Redirect after a short delay
                    setTimeout(() => {
                        window.location.href = data.redirect_url;
                    }, 2000);
                } else {
                    errorDiv.textContent = data.message || 'An error occurred.';
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            })
            .catch(err => {
                errorDiv.textContent = 'A server error occurred.';
                btn.disabled = false;
                btn.innerHTML = originalText;
            });
        });
    }

    if (deleteForm) {
        deleteForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Confirmation prompt for a destructive action
            if (!confirm('Are you absolutely sure you want to permanently delete your account? This action cannot be undone.')) {
                return;
            }

            const btn = document.getElementById('deleteBtn');
            const originalText = btn.innerHTML;
            
            btn.disabled = true;
            btn.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Deleting...`;
            errorDiv.textContent = '';

            const formData = new FormData(this);

            fetch("{{ route('account.delete') }}", {
                method: 'POST',
                body: formData,
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': formData.get('_token') }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    toastr.warning(data.message);
                    setTimeout(() => {
                        window.location.href = data.redirect_url;
                    }, 2000);
                } else {
                    errorDiv.textContent = data.message || 'An error occurred.';
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            })
            .catch(err => {
                errorDiv.textContent = 'A server error occurred.';
                btn.disabled = false;
                btn.innerHTML = originalText;
            });
        });
    }
});
</script>
{{-- Script for Dynamic Order Tracking --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const trackBtn = document.getElementById('track-order-btn');
    const invoiceInput = document.getElementById('invoice-no-input');
    const loader = document.getElementById('tracking-loader');
    const errorDiv = document.getElementById('tracking-error');
    const resultsContainer = document.getElementById('tracking-results-container');
    
    // DOM elements for results
    const invoiceNoSpan = document.getElementById('tracking-invoice-no');
    const orderDateSpan = document.getElementById('tracking-order-date');
    const statusBadge = document.getElementById('tracking-status-badge');
    const progressBarContainer = document.getElementById('progress-bar-container');
    const historyTbody = document.getElementById('tracking-history-tbody');
    
    const trackOrder = () => {
        const invoiceNo = invoiceInput.value.trim();
        if (!invoiceNo) {
            errorDiv.textContent = 'Please enter an invoice number.';
            errorDiv.style.display = 'block';
            resultsContainer.style.display = 'none';
            return;
        }

        // Reset UI
        loader.style.display = 'block';
        errorDiv.style.display = 'none';
        resultsContainer.style.display = 'none';

        fetch("{{ route('track.order') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
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
            if (data.error) {
                 throw new Error(data.error);
            }
            renderTrackingInfo(data);
        })
        .catch(error => {
            const errorMessage = error.message || 'Order not found or an error occurred.';
            errorDiv.textContent = errorMessage;
            errorDiv.style.display = 'block';
        })
        .finally(() => {
            loader.style.display = 'none';
        });
    };

    trackBtn.addEventListener('click', trackOrder);
    // Allow tracking by pressing Enter
    invoiceInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            trackOrder();
        }
    });

    function renderTrackingInfo(order) {
    // 1. Populate Header & Progress Bar (existing logic)
    invoiceNoSpan.textContent = `#${order.invoice_no}`;
    orderDateSpan.textContent = order.formatted_created_at;
    statusBadge.textContent = order.status;
    renderProgressBar(order.status, order.tracking_history);

    // 2. NEW: Render Order Items Table
    const itemsTbody = document.getElementById('order-items-tbody');
    itemsTbody.innerHTML = ''; // Clear previous results
    if (order.order_details && order.order_details.length > 0) {
        order.order_details.forEach(item => {
            const row = document.createElement('tr');
            // Create a badge for payment status
            const paymentStatusBadge = order.payment_status === 'paid' 
                ? `<span class="profile-badge success-bg">Paid</span>` 
                : `<span class="profile-badge danger-bg">Unpaid</span>`;

            row.innerHTML = `
                <td>${item.product_name || 'Product not found'}</td>
                <td>${item.quantity}</td>
                <td>৳ ${parseFloat(item.subtotal).toFixed(2)}</td>
                <td class="text-capitalize">${paymentStatusBadge}</td>
            `;
            itemsTbody.appendChild(row);
        });
    } else {
        itemsTbody.innerHTML = `<tr><td colspan="4" class="text-center">No items found for this order.</td></tr>`;
    }
    
    // 3. Render Tracking History Table (existing logic)
    historyTbody.innerHTML = ''; // Clear previous results
    if (order.tracking_history && order.tracking_history.length > 0) {
        order.tracking_history.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.bd_date || ''}</td>
                <td>${item.bd_time || ''}</td>
                <td class="text-capitalize">${item.status || ''}</td>
            `;
            historyTbody.appendChild(row);
        });
    } else {
         const row = document.createElement('tr');
         row.innerHTML = `<td colspan="3" class="text-center">No tracking history available yet.</td>`;
         historyTbody.appendChild(row);
    }

    // 4. Show the results container (existing logic)
    resultsContainer.style.display = 'block';
}

    function renderProgressBar(currentStatus, history) {
        const lowerCurrentStatus = currentStatus.toLowerCase();
        const isTerminal = ['cancelled', 'failed to delivery'].includes(lowerCurrentStatus);

        // Create a map of statuses from history for quick lookup
        const historyMap = new Map();
        history.forEach(item => {
            const status = item.status.toLowerCase();
            if (!historyMap.has(status)) {
                historyMap.set(status, item.bd_date);
            }
        });
        
        const allSteps = progressBarContainer.querySelectorAll('.order-tracking-progress-step');

        allSteps.forEach(step => {
            const stepStatus = step.dataset.status;
            const dateEl = step.querySelector('.order-tracking-step-date');

            // Reset styles and content
            step.classList.remove('completed', 'current', 'danger', 'd-none');
            step.style.display = ''; // Reset display style
            if(dateEl) dateEl.textContent = '';
            
            if (isTerminal) {
                // If cancelled or failed, only show 'pending' and the terminal step
                if(stepStatus !== 'pending' && stepStatus !== lowerCurrentStatus) {
                   step.style.display = 'none';
                }
            } else {
                 // Hide the terminal steps during a normal flow
                 if (['cancelled', 'failed to delivery'].includes(stepStatus)) {
                    step.style.display = 'none';
                 }
            }
            
            // Apply 'completed' class and date if status is in history
            if (historyMap.has(stepStatus)) {
                step.classList.add('completed');
                if(dateEl) dateEl.textContent = historyMap.get(stepStatus);
            }
        });
        
        // Find the most recent step from history to mark as 'current'
        const latestHistoryItem = history[0];
        if (latestHistoryItem) {
            const latestStatus = latestHistoryItem.status.toLowerCase();
            const currentStep = progressBarContainer.querySelector(`.order-tracking-progress-step[data-status="${latestStatus}"]`);
            if (currentStep) {
                currentStep.classList.remove('completed'); // 'current' takes precedence
                currentStep.classList.add('current');
                if (isTerminal) {
                    currentStep.classList.add('danger');
                }
            }
        }
    }
});
</script>
@endsection

