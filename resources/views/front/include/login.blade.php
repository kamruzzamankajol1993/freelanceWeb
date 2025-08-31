 <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content login-modal position-relative p-4">
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
              <h2 class="modal-title fs-4 fw-bold" id="loginModalLabel">Hello Again! Please Log In</h2>
            </div>

            <div class="d-flex justify-content-between mb-md-4 account-selection">
              <button type="button" class="btn btn-outline-primary account-btn active" data-account="customer">Customer
                Account</button>
              <button type="button" class="btn btn-outline-secondary account-btn" data-account="seller">Seller
                Account</button>
            </div>

            <form>
              <div class="mb-md-3 mb-2 text-start">
                <label for="emailInput" class="form-label fw-bold">Email</label>
                <input type="email" class="form-control" id="emailInput" placeholder="example@gmail.com">
              </div>
              <div class="mb-md-3 mb-2 text-start">
                <label for="passwordInput" class="form-label fw-bold">Password</label>
                <input type="password" class="form-control" id="passwordInput" placeholder="Enter password">
              </div>
              <div class="d-flex justify-content-between align-items-center mb-2 mb-md-4">
                <div class="form-check custom-checkbox">
                  <input class="form-check-input" type="checkbox" value="" id="termsCheckbox">
                  <label class="form-check-label" for="termsCheckbox">
                    I have read and agree to the Terms Conditions
                  </label>
                </div>
                <a href="#" class="text-decoration-none forgot-password-link" data-bs-toggle="modal"
                  data-bs-target="#forgotPasswordModal">
                  Forgot Password?
                </a>

              </div>
              <div class="mb-2 mb-md-4 mb-2">
                <button type="submit" class="btn access-now-btn">Access Now</button>
              </div>

              <div class="join-us-using mb-2 mb-md-4 ">
                <span>Join Us Using</span>
              </div>

              <div class="login-useful-link">
                <p class="mb-2">Can't have an account? <a href="#" class="text-decoration-none fw-bold community-link"
                    data-bs-toggle="modal" data-bs-target="#staticBackdrop">Join the Community</a></p>
                <p>Become a seller? <a href="#" class="text-decoration-none fw-bold seller-link">Join Our Seller
                    Network</a></p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>