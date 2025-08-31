<div class="modal fade" id="otpModal" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4 position-relative">

          <div class="modal-header border-0 pb-0">
            <!-- Custom Font Awesome close icon in top-right corner -->
            <button type="button" class="btn bg-transparent modal-close-btn position-absolute" data-bs-dismiss="modal"
              aria-label="Close">
              <i class="fas fa-xmark"></i>
            </button>
          </div>

          <div class="modal-body">
            <div class="mb-md-4 d-flex flex-column align-items-center mb-2">
              <img src="assets/img/pick-logo.png" alt="Logo" class="logo-img mb-md-3 mb-2">
              <h2 class="modal-title fs-4 fw-bold" id="loginModalLabel">Let's Confirm It's You</h2>
            </div>
            <form id="otpForm">
              <div class="otp-container">
                <h6>Please check your email</h6>
                <p>We've sent a code to <strong id="otpEmail">pickndrop@mail.com</strong></p>
                <div class="d-flex justify-content-center mb-3">
                  <input type="text" class="otp-input" maxlength="1" data-index="0" placeholder="0">
                  <input type="text" class="otp-input" maxlength="1" data-index="1" placeholder="0">
                  <input type="text" class="otp-input" maxlength="1" data-index="2" placeholder="0">
                  <input type="text" class="otp-input" maxlength="1" data-index="3" placeholder="0">
                </div>
                <div class="resend-text mb-3">
                  Didn't get a code? <a href="#" id="resendOtp">Click to resend.</a>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn access-now-btn px-5">Verify OTP</button>
                </div>
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>