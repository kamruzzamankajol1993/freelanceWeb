<div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content position-relative">
          <div class="modal-header border-0 pb-0 mb-5">
            <!-- Custom Font Awesome close icon in top-right corner -->
            <button type="button" class="btn bg-transparent modal-close-btn position-absolute" data-bs-dismiss="modal"
              aria-label="Close">
              <i class="fas fa-xmark"></i>
            </button>
          </div>
          <div class="modal-body border-0">
            <div class="p-md-5 login-modal">
              <div class="mb-md-4 d-flex flex-column align-items-center mb-2">
                <img src="assets/img/pick-logo.png" alt="Logo" class="logo-img mb-md-3 mb-2">
                <h2 class="modal-title fs-4 fw-bold" id="loginModalLabel">Let's Get Started</h2>
              </div>
              <div class="row overflow-hidden">
                <!-- Left: Identity Information -->
                <div class="col-lg-6 pe-md-0">
                  <div class="position-relative column-devider">
                    <h4 class="manage-personal-info-title py-4 border-bottom">Identity Information</h4>
                    <div class="pe-md-4">
                      <div class="d-flex justify-content-between mb-md-4 account-selection">
                        <button type="button" class="btn btn-outline-primary account-btn active"
                          data-account="customer">Customer
                          Account</button>
                        <button type="button" class="btn btn-outline-secondary account-btn" data-account="seller">Seller
                          Account</button>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Full Name *</label>
                        <input type="text" class="form-control" placeholder="Enter full name">
                      </div>

                      <div class="mb-3">
                        <label class="form-label">Phone Number *</label>
                        <input type="text" class="form-control" placeholder="Enter Phone Number">
                      </div>

                      <div class="mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" class="form-control" placeholder="example@gmail.com">
                      </div>

                      <div class="mb-3">
                        <label class="form-label">Address *</label>
                        <input type="text" class="form-control" placeholder="Address">
                      </div>

                      <div class="mb-3">
                        <label class="form-label">Country *</label>
                        <select class="form-select">
                          <option>Select Country</option>
                        </select>
                      </div>

                      <div class="row g-2">
                        <div class="col-4">
                          <label class="form-label">City</label>
                          <select class="form-select">
                            <option>Select City</option>
                          </select>
                        </div>
                        <div class="col-4">
                          <label class="form-label">State</label>
                          <input type="text" class="form-control" placeholder="Enter State">
                        </div>
                        <div class="col-4">
                          <label class="form-label">Zip Code</label>
                          <input type="text" class="form-control" placeholder="Zip Code">
                        </div>
                      </div>

                    </div>
                  </div>
                </div>

                <!-- Divider -->
                <div class="col-lg-6 ps-0">
                  <h4 class="manage-personal-info-title py-4 border-bottom ps-md-4">Authentication Settings</h4>
                  <div class="password-container ps-lg-4">
                    <!-- New Password Field -->
                    <div class="form-group">
                      <div class="password-field">
                        <label class="form-label">Set Password *</label>
                        <div class="input-group">
                          <input class="form-control manage-personal-info-input" type="password" id="newPassword"
                            placeholder="Create new password">
                          <span class="input-group-text toggle-password d-none" id="toggleNewPassword">
                            <i class="fas fa-eye"></i>
                          </span>
                        </div>
                      </div>
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="form-group">
                      <div class="password-field">
                        <label class="form-label">Confirm Password *</label>
                        <div class="input-group">
                          <input class="form-control manage-personal-info-input" type="password" id="confirmPassword"
                            placeholder="Confirm your new password">
                          <span class="input-group-text toggle-password d-none" id="toggleConfirmPassword">
                            <i class="fas fa-eye"></i>
                          </span>
                        </div>
                      </div>
                      <div class="match-error text-danger small mt-1" id="passwordMatchError" style="display: none;">
                        Passwords do not match
                      </div>
                    </div>

                    <!-- Password Strength Indicator -->
                    <div class="strength-container mt-3">
                      <div class="strength-bars d-flex gap-1 mb-2">
                        <div class="strength-bar flex-grow-1" id="bar1"></div>
                        <div class="strength-bar flex-grow-1" id="bar2"></div>
                        <div class="strength-bar flex-grow-1" id="bar3"></div>
                        <div class="strength-bar flex-grow-1" id="bar4"></div>
                      </div>
                      <div class="strength-label-container">
                        <span class="strength-label small" id="current-strength-label"></span>
                      </div>
                    </div>

                    <!-- Password Requirements -->
                    <div class="requirements small mt-3">
                      <div class="requirement" id="req-lower">
                        <i class="fas fa-times text-danger"></i>
                        <span>At least one lowercase letter</span>
                      </div>
                      <div class="requirement" id="req-length">
                        <i class="fas fa-times text-danger"></i>
                        <span>Minimum 8 characters</span>
                      </div>
                      <div class="requirement" id="req-upper">
                        <i class="fas fa-times text-danger"></i>
                        <span>At least one uppercase letter</span>
                      </div>
                      <div class="requirement" id="req-number">
                        <i class="fas fa-times text-danger"></i>
                        <span>At least one number</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-center flex-column align-items-center mt-5">
                <div class="d-flex justify-content-between align-items-center mb-2 mb-md-4">
                  <div class="form-check custom-checkbox">
                    <input class="form-check-input" type="checkbox" value="" id="termsCheckbox">
                    <label class="form-check-label" for="termsCheckbox">
                      I have read and agree to the Terms Conditions
                    </label>
                  </div>

                </div>
                <div class="mb-2 mb-md-4">
                  <button type="button" class="btn btn-primary access-now-btn" data-bs-toggle="modal"
                    data-bs-target="#otpModal">
                    Start Your Journey
                  </button>
                </div>

                <div class="join-us mb-2 mb-md-4 ">
                  <span>Join Us Using</span>
                </div>

                <div class="have-an-ac ">
                  <p class="mb-2">Already have an account? <a href="#" class="text-decoration-none fw-bold fw-bold"
                      data-bs-toggle="modal" data-bs-target="#loginModal">Welcome Back!</a></p>

                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>