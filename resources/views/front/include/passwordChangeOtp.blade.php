<!-- reset otp modal -->
<div class="modal fade" id="resetModal" tabindex="-1" aria-labelledby="resetModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4 position-relative">
      <div class="modal-header border-0 pb-0">
        <button type="button" class="btn bg-transparent modal-close-btn position-absolute" data-bs-dismiss="modal" aria-label="Close">
          <i class="fas fa-xmark"></i>
        </button>
      </div>
      <div class="modal-body">
        <div class="mb-md-4 d-flex flex-column align-items-center mb-2">
          <img src="{{$front_ins_url.$front_icon_name}}" alt="Logo" class="logo-img mb-md-3 mb-2">
          <h2 class="modal-title fs-4 fw-bold">Password Reset</h2>
        </div>
        <div class="otp-container text-center">
          <h6>Please check your email</h6>
          <p>We've sent a code to <strong id="passwordChangeOtpEmail">your-email@example.com</strong></p>
          
          <form id="passwordOtpForm" method="POST" action="{{ route('password.verify.otp') }}">
            @csrf
            <div class="d-flex justify-content-center my-4" id="password-otp-inputs">
              <input type="text" name="otp_1" class="otp-input" maxlength="1" required>
              <input type="text" name="otp_2" class="otp-input" maxlength="1" required>
              <input type="text" name="otp_3" class="otp-input" maxlength="1" required>
              <input type="text" name="otp_4" class="otp-input" maxlength="1" required>
            </div>
            {{-- Submit button has been removed --}}
          </form>

          <!-- Loader and Status Messages -->
          <div id="otp-verify-status" class="mt-3">
              <div id="otp-verify-loader" style="display: none;">
                  <div class="spinner-border text-primary" role="status">
                      <span class="visually-hidden">Loading...</span>
                  </div>
                  <p class="mt-2">Verifying...</p>
              </div>
              <div id="otp-verify-error" class="alert alert-danger" style="display: none;"></div>
          </div>

          <!-- Resend Section -->
          <div class="resend-text mt-4">
            Didn't get a code? 
            <a href="#" id="resendPassOtpLink">Click to resend.</a>
            <span id="resendPassTimer" class="text-muted" style="display: none;">Resend in <span id="timerPassValue">60</span>s</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const otpForm = document.getElementById('passwordOtpForm');
    const inputsContainer = document.getElementById('password-otp-inputs');
    const inputs = inputsContainer ? [...inputsContainer.querySelectorAll('.otp-input')] : [];
    const errorDiv = document.getElementById('otp-verify-error');
    const loaderDiv = document.getElementById('otp-verify-loader');

    // --- Auto-focus and auto-submit on keyup ---
    if (otpForm) {
        inputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                if (e.target.value && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    inputs[index - 1].focus();
                }
            });
            // Add keyup listener to the last input to trigger submission
            if (index === inputs.length - 1) {
                input.addEventListener('keyup', function() {
                    if (this.value.length === 1) {
                        submitPasswordResetOtp();
                    }
                });
            }
        });

        function submitPasswordResetOtp() {
            let otpValue = '';
            inputs.forEach(input => { otpValue += input.value; });

            if (otpValue.length !== 4) return;

            loaderDiv.style.display = 'block';
            errorDiv.style.display = 'none';
            inputs.forEach(input => input.disabled = true);

            const email = document.getElementById('passwordChangeOtpEmail').textContent;
            const formData = new FormData();
            formData.append('otp', otpValue);
            formData.append('email', email);
            formData.append('_token', otpForm.querySelector('input[name="_token"]').value);

            fetch("{{ route('password.verify.otp') }}", {
                method: 'POST',
                body: formData,
                headers: { 'Accept': 'application/json' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    toastr.success(data.message);
                    const otpModalEl = document.getElementById('resetModal');
                    const otpModal = bootstrap.Modal.getInstance(otpModalEl);
                    if (otpModal) otpModal.hide();
                    
                    const changePassModal = new bootstrap.Modal(document.getElementById('submitOtpModal'));
                    changePassModal.show();
                } else {
                    errorDiv.textContent = data.message || 'An error occurred.';
                    errorDiv.style.display = 'block';
                    resetOtpFields();
                }
            }).catch(error => {
                 errorDiv.textContent = 'A server error occurred.';
                 errorDiv.style.display = 'block';
                 resetOtpFields();
            });
        }
        
        function resetOtpFields() {
            loaderDiv.style.display = 'none';
            inputs.forEach(input => {
                input.disabled = false;
                input.value = '';
            });
            inputs[0].focus();
        }
    }

    // --- NEW RESEND OTP SCRIPT ---
    const resendLink = document.getElementById('resendPassOtpLink');
    const resendTimer = document.getElementById('resendPassTimer');
    const timerValue = document.getElementById('timerPassValue');
    let cooldownSeconds = 60;

    const startTimer = () => {
        resendLink.style.display = 'none';
        resendTimer.style.display = 'inline';
        let remaining = cooldownSeconds;
        timerValue.textContent = remaining;
        const interval = setInterval(() => {
            remaining--;
            timerValue.textContent = remaining;
            if (remaining <= 0) {
                clearInterval(interval);
                resendTimer.style.display = 'none';
                resendLink.style.display = 'inline';
            }
        }, 1000);
    };

    if (resendLink) {
        resendLink.addEventListener('click', function(e) {
            e.preventDefault();
            if (resendTimer.style.display !== 'none') return;

            const originalText = this.innerHTML;
            this.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...`;
            this.classList.add('disabled');

            const email = document.getElementById('passwordChangeOtpEmail').textContent;
            const csrfToken = otpForm.querySelector('input[name="_token"]').value;

            fetch("{{ route('password.email') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ email: email })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    toastr.success(data.message);
                    startTimer();
                } else {
                    toastr.error(data.message || 'Could not resend OTP.');
                }
            })
            .catch(error => {
                toastr.error('An unexpected error occurred.');
            })
            .finally(() => {
                if (resendTimer.style.display === 'none') {
                    this.innerHTML = originalText;
                    this.classList.remove('disabled');
                }
            });
        });
    }
});
</script>

