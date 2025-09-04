<div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content position-relative">
          <div class="modal-header border-0 pb-0 mb-5">
            <button type="button" class="btn bg-transparent modal-close-btn position-absolute" data-bs-dismiss="modal" aria-label="Close">
              <i class="fas fa-xmark"></i>
            </button>
          </div>
          <div class="modal-body border-0">
            <!-- FORM START -->
            <form id="registerForm" method="POST" action="{{ route('register.submit') }}">
                @csrf
                <div class="p-md-5 login-modal">
                  <div class="mb-md-4 d-flex flex-column align-items-center mb-2">
                    <img src="{{ isset($front_ins_url) && isset($front_icon_name) ? $front_ins_url . $front_icon_name : '' }}" alt="Logo" class="logo-img mb-md-3 mb-2">
                    <h2 class="modal-title fs-4 fw-bold" id="loginModalLabel">Let's Get Started</h2>
                  </div>

                  <div id="register-errors" class="alert alert-danger" style="display: none;"></div>

                  <div class="row overflow-hidden">
                    <!-- Left: Identity Information -->
                    <div class="col-lg-6 pe-md-0">
                      <div class="position-relative column-devider">
                        <h4 class="manage-personal-info-title py-4 border-bottom">Identity Information</h4>
                        <div class="pe-md-4">
                          <div class="mb-3">
                            <label class="form-label">Full Name *</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter full name" value="{{ old('name') }}" required>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Phone Number *</label>
                            <input type="text" name="phone" class="form-control" placeholder="Enter Phone Number" value="{{ old('phone') }}" required>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" class="form-control" placeholder="example@gmail.com" value="{{ old('email') }}" required>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Address *</label>
                            <input type="text" name="address" class="form-control" placeholder="Address" value="{{ old('address') }}" required>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Right: Authentication Settings -->
                    <div class="col-lg-6 ps-0">
                      <h4 class="manage-personal-info-title py-4 border-bottom ps-md-4">Authentication Settings</h4>
                      <div class="password-container ps-lg-4">
                        <div class="form-group">
                          <div class="password-field">
                            <label class="form-label">Set Password *</label>
                            <div class="input-group">
                              <input class="form-control manage-personal-info-input" type="password" name="password" id="newPassword" placeholder="Create new password" required>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="password-field">
                            <label class="form-label">Confirm Password *</label>
                            <div class="input-group">
                              <input class="form-control manage-personal-info-input" type="password" name="password_confirmation" id="confirmPassword" placeholder="Confirm your new password" required>
                            </div>
                          </div>
                        </div>
                        
                        <div class="requirements small mt-3">
                          <div class="requirement" id="req-lower"><i class="fas fa-times text-danger"></i><span>At least one lowercase letter</span></div>
                          <div class="requirement" id="req-length"><i class="fas fa-times text-danger"></i><span>Minimum 8 characters</span></div>
                          <div class="requirement" id="req-upper"><i class="fas fa-times text-danger"></i><span>At least one uppercase letter</span></div>
                          <div class="requirement" id="req-number"><i class="fas fa-times text-danger"></i><span>At least one number</span></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="d-flex justify-content-center flex-column align-items-center mt-5">
                    <div class="d-flex justify-content-between align-items-center mb-2 mb-md-4">
                      <div class="form-check custom-checkbox">
                        <input class="form-check-input" type="checkbox" name="terms" id="termsCheckbox" required>
                        <label class="form-check-label" for="termsCheckbox">I have read and agree to the Terms Conditions</label>
                      </div>
                    </div>
                    <div class="mb-2 mb-md-4">
                      <button type="submit" id="registerBtn" class="btn btn-primary access-now-btn">Start Your Journey</button>
                    </div>
                    <div class="have-an-ac">
                      <p class="mb-2">Already have an account? <a href="#" class="text-decoration-none fw-bold" data-bs-toggle="modal" data-bs-target="#loginModal">Welcome Back!</a></p>
                    </div>
                  </div>
                </div>
            </form>
            <!-- FORM END -->
          </div>
        </div>
      </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- Password Validation Script ---
    const newPasswordInput = document.getElementById('newPassword');
    if (newPasswordInput) {
        newPasswordInput.addEventListener('keyup', function() {
            const password = this.value;
            const requirements = {
                lower: document.getElementById('req-lower'),
                length: document.getElementById('req-length'),
                upper: document.getElementById('req-upper'),
                number: document.getElementById('req-number')
            };
            const validateRequirement = (element, isValid) => {
                const icon = element.querySelector('i');
                if (isValid) {
                    icon.classList.remove('fa-times', 'text-danger');
                    icon.classList.add('fa-check', 'text-success');
                } else {
                    icon.classList.remove('fa-check', 'text-success');
                    icon.classList.add('fa-times', 'text-danger');
                }
            };
            validateRequirement(requirements.lower, /[a-z]/.test(password));
            validateRequirement(requirements.length, password.length >= 8);
            validateRequirement(requirements.upper, /[A-Z]/.test(password));
            validateRequirement(requirements.number, /[0-9]/.test(password));
        });
    }

    // --- AJAX FORM SUBMISSION SCRIPT ---
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault(); // This is the most important line to prevent page reload.

            const registerBtn = document.getElementById('registerBtn');
            const registerErrors = document.getElementById('register-errors');
            
            registerBtn.disabled = true;
            registerBtn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...`;
            registerErrors.style.display = 'none';
            registerErrors.innerHTML = '';

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': formData.get('_token'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Check if Bootstrap is loaded before trying to use it
                    if (typeof bootstrap !== 'undefined') {
                        const registerModalEl = document.getElementById('staticBackdrop');
                        const registerModal = bootstrap.Modal.getInstance(registerModalEl);
                        
                        // Safely hide the current modal
                        if (registerModal) {
                            registerModal.hide();
                        }

                        // Update email and show the OTP modal
                        document.getElementById('otpEmail').textContent = formData.get('email');
                        const otpModalEl = document.getElementById('otpModal');
                        if (otpModalEl) {
                            const otpModal = new bootstrap.Modal(otpModalEl);
                            otpModal.show();
                        }
                    }
                } else {
                    let errorHtml = '<ul>';
                    if (data.errors) {
                        for (const error in data.errors) {
                            errorHtml += `<li>${data.errors[error][0]}</li>`;
                        }
                    } else {
                        errorHtml += `<li>${data.message || 'An unknown error occurred.'}</li>`;
                    }
                    errorHtml += '</ul>';
                    registerErrors.innerHTML = errorHtml;
                    registerErrors.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Registration Error:', error);
                registerErrors.innerHTML = 'An unexpected server error occurred. Please try again later.';
                registerErrors.style.display = 'block';
            })
            .finally(() => {
                registerBtn.disabled = false;
                registerBtn.innerHTML = 'Start Your Journey';
            });
        });
    }
});
</script>

