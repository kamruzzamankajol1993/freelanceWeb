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
                                            <input type="text" class="form-control pnr" value="#PND-{{ $user->customer_id ?? 'N/A' }}" readonly>
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

                             <!-- Goodbye Section -->
                            <div class="manage-personal-info-goodbye-section ps-lg-5 mt-4">
                                <h6 class="manage-personal-info-section-title">Goodbye?</h6>
                                <p class="small text-muted">These actions may be permanent.</p>

                                <form id="deactivateForm" class="mt-3">
                                    @csrf
                                    <div class="mb-2">
                                        <input type="text" name="reason" class="form-control manage-personal-info-input" placeholder="Reason for deactivating account" required>
                                    </div>
                                    <button type="submit" id="deactivateBtn" class="btn manage-personal-info-btn-danger mb-4 px-4">Deactivate Account</button>
                                </form>

                                <form id="deleteForm" class="mt-3">
                                     @csrf
                                    <div class="mb-2">
                                        <input type="text" name="reason" class="form-control manage-personal-info-input" placeholder="Reason for permanently deleting account" required>
                                    </div>
                                    <button type="submit" id="deleteBtn" class="btn btn-danger px-4">Permanently Delete Account</button>
                                </form>
                                <div id="goodbye-error" class="small text-danger mt-2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>