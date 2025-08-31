<!-- forget password modal -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content position-relative">
          <div class="modal-header border-0 pb-0 mb-5">
            <!-- Custom Font Awesome close icon in top-right corner -->
            <button type="button" class="btn bg-transparent modal-close-btn position-absolute" data-bs-dismiss="modal"
              aria-label="Close">
              <i class="fas fa-xmark"></i>
            </button>
          </div>
          <div class="modal-body border-0 px-md-5">
            <div class="mb-md-4 d-flex flex-column align-items-center mb-2">
              <img src="assets/img/pick-logo.png" alt="Logo" class="logo-img mb-md-3 mb-2">
              <h2 class="modal-title fs-4 fw-bold" id="loginModalLabel">Reset Your Account Password</h2>
              <div class="resend-text">
                No worries, we'll send you reset instructions.
              </div>

            </div>
            <form id="forgotPasswordForm">
              <div class="mb-md-3 mb-2 text-start">
                <input type="email" class="form-control py-3" id="resetEmailInput" placeholder="Your registered email" required>
              </div>
              <div class="mb-2 mb-md-4 text-center mb-2">
                <button type="submit" class="btn access-now-btn px-5">Continue</button>
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>

    <!-- reset modal -->
    <div class="modal fade" id="resetModal" tabindex="-1" aria-labelledby="resetModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4 position-relative">
          <div class="modal-header border-0 pb-0 mb-5">
            <!-- Custom Font Awesome close icon in top-right corner -->
            <button type="button" class="btn bg-transparent modal-close-btn position-absolute" data-bs-dismiss="modal"
              aria-label="Close">
              <i class="fas fa-xmark"></i>
            </button>
          </div>

          <div class="modal-body">
            <div class="mb-md-4 d-flex flex-column align-items-center mb-2">
              <img src="assets/img/pick-logo.png" alt="Logo" class="logo-img mb-md-3 mb-2">
              <h2 class="modal-title fs-4 fw-bold" id="loginModalLabel">Password Reset</h2>
            </div>
            <div class="otp-container">
              <h6>Please check your email</h6>
              <p>We've sent a code to <strong>pickndrop@gmail.com</strong></p>
              <div class="d-flex justify-content-center mb-3">
                <div class="otp-box">4</div>
                <div class="otp-box">8</div>
                <div class="otp-box">9</div>
                <div class="otp-box">6</div>
              </div>
              <div class="resend-text">
                Didn't get a code? <a href="#">Click to resend.</a>
              </div>
              <div class="mb-2 mb-md-4 text-center mb-2 mt-2">
                <button type="submit" class="btn access-now-btn px-5" data-bs-toggle="modal"
                  data-bs-target="#submitOtpModal">Submit</button>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- reset password modal-->
    <div class="modal fade" id="submitOtpModal" tabindex="-1" aria-labelledby="submitOtpModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4 position-relative">
          <div class="modal-header border-0 pb-0">
            <!-- Custom Font Awesome close icon in top-right corner -->
            <button type="button" class="btn bg-transparent modal-close-btn position-absolute" data-bs-dismiss="modal"
              aria-label="Close">
              <i class="fas fa-xmark"></i>
            </button>
          </div>
          <div class="modal-body px-0 text-center">
            <div class="mb-md-4 mb-2">
              <img src="assets/img/pick-logo.png" alt="Logo" class="logo-img mb-md-3 mb-2">
              <h2 class="modal-title fs-4 fw-bold" id="loginModalLabel">Let's Secure Your Account</h2>
            </div>

            <div class="password-container">
              <!-- New Password Field -->
              <div class="form-group">
                <div class="password-field">
                  <label class="form-label text-start">Set New Password *</label>
                  <input class="form-control manage-personal-info-input" type="password" id="newPassword"
                    placeholder="Create new password">

                </div>
              </div>
              <div class="form-group">
                <div class="password-field">
                  <label class="form-label text-start">Confirm Password *</label>
                  <input class="form-control manage-personal-info-input" type="password" id="confirmPassword"
                    placeholder="Confirm your new password">

                </div>
                <div class="match-error" id="passwordMatchError">
                  Passwords do not match
                </div>
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
              <div class="requirements">
                <div class="requirement" id="req-lower">
                  <i class="fas fa-times"></i>
                  <span>At least one lowercase letter</span>
                </div>
                <div class="requirement" id="req-length">
                  <i class="fas fa-times"></i>
                  <span>Minimum 8 characters</span>
                </div>
                <div class="requirement" id="req-upper">
                  <i class="fas fa-times"></i>
                  <span>At least one uppercase letter</span>
                </div>
                <div class="requirement" id="req-number">
                  <i class="fas fa-times"></i>
                  <span>At least one number</span>
                </div>
              </div>

              <!-- Confirm Password Field -->
              <div class="mb-2 mb-md-4 text-center mb-2 mt-2">
                <button type="submit" class="btn access-now-btn px-5" data-bs-toggle="modal"
                  data-bs-target="#submitOtpModal">Reset Password</button>
              </div>


            </div>

          </div>
        </div>
      </div>
    </div>