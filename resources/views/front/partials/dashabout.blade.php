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
                                    <small class="text-muted">#PND-{{ $user->customer_id ?? 'N/A' }}</small>
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
                                            <th>Action</th>
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
                                            <td>

                                                <a href="{{ url('/invoice/'.$order->id.'/print') }}" target="_blank" class="me-2">
                                                  <span>
                                <img src="{{asset('/')}}public/front/assets/img/pdf.png" alt="">
                              </span>
                                                </a>
                                                <a href="#" class="me-2 view-order-btn" data-bs-toggle="modal" data-bs-target="#orderDetailModal" data-order-id="{{ $order->id }}" title="View Details">
                                                    <span><img src="{{asset('/')}}public/front/assets/img/eye.png" alt="View"></span>
                                                </a>
                                            </td>
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
                                            <th>Action</th>
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
                                            <td>
                                               <a href="{{ url('/invoice/'.$order->id.'/print') }}" target="_blank" class="me-2">
                                                  <span>
                                <img src="{{asset('/')}}public/front/assets/img/pdf.png" alt="">
                              </span>
                                                </a>
                                                <a href="#" class="me-2 view-order-btn" data-bs-toggle="modal" data-bs-target="#orderDetailModal" data-order-id="{{ $order->id }}" title="View Details">
                                                    <span><img src="{{asset('/')}}public/front/assets/img/eye.png" alt="View"></span>
                                                </a>
                                            </td>
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