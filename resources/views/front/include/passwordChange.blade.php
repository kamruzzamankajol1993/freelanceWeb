<!-- reset password modal-->
<div class="modal fade" id="submitOtpModal" tabindex="-1" aria-labelledby="submitOtpModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4 position-relative">
      <div class="modal-header border-0 pb-0">
        <button type="button" class="btn bg-transparent modal-close-btn position-absolute" data-bs-dismiss="modal" aria-label="Close">
          <i class="fas fa-xmark"></i>
        </button>
      </div>
      <div class="modal-body px-0 text-center">
        <div class="mb-md-4 mb-2">
          <img src="{{$front_ins_url.$front_icon_name}}" alt="Logo" class="logo-img mb-md-3 mb-2">
          <h2 class="modal-title fs-4 fw-bold">Let's Secure Your Account</h2>
        </div>

        <div id="password-change-error" class="alert alert-danger mx-3" style="display: none;"></div>

        <form id="passwordChangeForm" method="POST" action="{{ route('password.update') }}">
            @csrf
            <div class="password-container text-start px-3">
              <div class="form-group">
                  <label class="form-label">Set New Password *</label>
                  <input class="form-control manage-personal-info-input" type="password" name="password" id="resetNewPassword" placeholder="Create new password" required>
              </div>
              <div class="form-group mt-3">
                  <label class="form-label">Confirm Password *</label>
                  <input class="form-control manage-personal-info-input" type="password" name="password_confirmation" id="resetConfirmPassword" placeholder="Confirm your new password" required>
              </div>
              
              <!-- Password Match Error -->
              <div class="match-error small text-danger mt-1" id="resetPasswordMatchError" style="display: none;">
                Passwords do not match
              </div>

              <!-- Password Requirements -->
              <div class="requirements small mt-3">
                <div class="requirement" id="reset-req-lower"><i class="fas fa-times text-danger"></i><span>At least one lowercase letter</span></div>
                <div class="requirement" id="reset-req-length"><i class="fas fa-times text-danger"></i><span>Minimum 8 characters</span></div>
                <div class="requirement" id="reset-req-upper"><i class="fas fa-times text-danger"></i><span>At least one uppercase letter</span></div>
                <div class="requirement" id="reset-req-number"><i class="fas fa-times text-danger"></i><span>At least one number</span></div>
              </div>
              
              <div class="mb-2 mb-md-4 text-center mt-4">
                <button type="submit" id="updatePasswordBtn" class="btn access-now-btn px-5">Reset Password</button>
              </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordChangeForm = document.getElementById('passwordChangeForm');
    const updateBtn = document.getElementById('updatePasswordBtn');
    const errorDiv = document.getElementById('password-change-error');
    
    // --- LIVE PASSWORD VALIDATION SCRIPT ---
    const newPasswordInput = document.getElementById('resetNewPassword');
    const confirmPasswordInput = document.getElementById('resetConfirmPassword');
    const matchError = document.getElementById('resetPasswordMatchError');
    const requirements = {
        lower: document.getElementById('reset-req-lower'),
        length: document.getElementById('reset-req-length'),
        upper: document.getElementById('reset-req-upper'),
        number: document.getElementById('reset-req-number')
    };

    if (newPasswordInput) {
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

        const checkPasswords = () => {
            const password = newPasswordInput.value;
            // Strength validation
            validateRequirement(requirements.lower, /[a-z]/.test(password));
            validateRequirement(requirements.length, password.length >= 8);
            validateRequirement(requirements.upper, /[A-Z]/.test(password));
            validateRequirement(requirements.number, /[0-9]/.test(password));
            
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


    // --- FORM SUBMISSION SCRIPT ---
    if (passwordChangeForm) {
        passwordChangeForm.addEventListener('submit', function(e) {
            e.preventDefault();

            updateBtn.disabled = true;
            updateBtn.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Updating...`;
            errorDiv.style.display = 'none';

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': formData.get('_token') }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    toastr.success(data.message);
                    const thisModalEl = document.getElementById('submitOtpModal');
                    const thisModal = bootstrap.Modal.getInstance(thisModalEl);
                    if (thisModal) thisModal.hide();

                    const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                    loginModal.show();
                } else {
                    errorDiv.textContent = data.message || 'An error occurred.';
                    errorDiv.style.display = 'block';
                }
            })
            .catch(error => {
                 errorDiv.textContent = 'A server error occurred.';
                 errorDiv.style.display = 'block';
            })
            .finally(() => {
                updateBtn.disabled = false;
                updateBtn.innerHTML = 'Reset Password';
            });
        });
    }
});
</script>

