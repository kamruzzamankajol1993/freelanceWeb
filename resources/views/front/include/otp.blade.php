<style>
    .otp-input { width: 50px; height: 50px; text-align: center; font-size: 1.5rem; margin: 0 5px; border-radius: 8px; border: 1px solid #ced4da; }
    .otp-input:focus { border-color: #80bdff; outline: 0; box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25); }
    #resendOtpLink { cursor: pointer; color: #0d6efd; }
    #resendOtpLink.disabled { color: #6c757d; cursor: not-allowed; text-decoration: none; }
</style>
<div class="modal fade" id="otpModal" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4 position-relative">

          <div class="modal-header border-0 pb-0">
            <button type="button" class="btn bg-transparent modal-close-btn position-absolute" data-bs-dismiss="modal"
              aria-label="Close">
              <i class="fas fa-xmark"></i>
            </button>
          </div>

          <div class="modal-body">
            <div class="mb-md-4 d-flex flex-column align-items-center mb-2">
              <img src="{{ isset($front_ins_url) && isset($front_icon_name) ? $front_ins_url . $front_icon_name : '' }}" alt="Logo" class="logo-img mb-md-3 mb-2">
              <h2 class="modal-title fs-4 fw-bold" id="loginModalLabel">Let's Confirm It's You</h2>
            </div>
           <div class="profile-container-fluid overflow-hidden py-4">
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            <div class="otp-container text-center" style="max-width: 450px;">
                <h6>Please check your email</h6>
                <p>We've sent a code to <strong id="otpEmail">{{ session('email') }}</strong></p>
                
                <form method="POST" action="{{ route('otp.verify') }}" id="otpForm">
                    @csrf
                    <div class="d-flex justify-content-center my-4" id="otp-inputs">
                        <input type="text" name="otp_1" class="otp-input" maxlength="1" data-index="0"  required>
                        <input type="text" name="otp_2" class="otp-input" maxlength="1" data-index="1"  required>
                        <input type="text" name="otp_3" class="otp-input" maxlength="1" data-index="2"  required>
                        <input type="text" name="otp_4" class="otp-input" maxlength="1" data-index="3"  required>
                    </div>
                    {{-- The submit button is now removed --}}
                </form>

                <!-- Loader and Status Messages -->
                <div id="otp-status" class="mt-3">
                    <div id="otp-loader" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Verifying...</p>
                    </div>
                    <div id="otp-error" class="alert alert-danger" style="display: none;"></div>
                </div>

                <!-- Dynamic Resend Section -->
                <div class="resend-text mb-3 mt-4">
                    Didn't get a code? 
                    <a href="#" id="resendOtpLink">Click to resend.</a>
                    <span id="resendTimer" class="text-muted" style="display: none;">Resend in <span id="timerValue">60</span>s</span>
                </div>

                <!-- Hidden form for the resend action -->
                <form id="resendForm" action="{{ route('otp.resend') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
          </div>

        </div>
      </div>
    </div>
    <script>
document.addEventListener("DOMContentLoaded", function () {
    const otpForm = document.getElementById('otpForm');
    const inputsContainer = document.getElementById('otp-inputs');
    const inputs = inputsContainer ? [...inputsContainer.querySelectorAll('.otp-input')] : [];
    const otpLoader = document.getElementById('otp-loader');
    const otpError = document.getElementById('otp-error');
    
    // --- Auto-focus and auto-submit logic ---
    if(inputs.length > 0) {
        inputs[0].focus();

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

            if (index === inputs.length - 1) {
                input.addEventListener('keyup', function() {
                    if (this.value.length === 1) {
                        submitOtp();
                    }
                });
            }
        });
    }

    function submitOtp() {
        let otpValue = '';
        inputs.forEach(input => { otpValue += input.value; });

        if (otpValue.length !== 4) return;

        otpLoader.style.display = 'block';
        otpError.style.display = 'none';
        inputs.forEach(input => input.disabled = true);

        const formData = new FormData();
        formData.append('otp', otpValue);
        formData.append('_token', otpForm.querySelector('input[name="_token"]').value);

        fetch(otpForm.action, {
            method: 'POST',
            body: formData,
            headers: { 'Accept': 'application/json' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                otpLoader.querySelector('p').textContent = 'Success! Redirecting...';
                window.location.href = data.redirect_url;
            } else {
                otpError.textContent = data.message || 'An error occurred.';
                otpError.style.display = 'block';
                otpLoader.style.display = 'none';
                inputs.forEach(input => {
                    input.disabled = false;
                    input.value = '';
                });
                inputs[0].focus();
            }
        })
        .catch(error => {
            console.error('OTP Submit Error:', error);
            otpError.textContent = 'A server error occurred. Please try again.';
            otpError.style.display = 'block';
            otpLoader.style.display = 'none';
            inputs.forEach(input => input.disabled = false);
        });
    }

    // --- RESEND OTP LOGIC ---
    const resendLink = document.getElementById('resendOtpLink');
    const resendTimer = document.getElementById('resendTimer');
    const timerValue = document.getElementById('timerValue');
    const resendForm = document.getElementById('resendForm');
    
    if (resendLink) {
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

        resendLink.addEventListener('click', function(e) {
            e.preventDefault();
            if (resendTimer.style.display !== 'none') return;

            const originalText = this.innerHTML;
            this.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...`;
            this.classList.add('disabled');

            fetch(resendForm.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': resendForm.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    toastr.success(data.message);
                    startTimer();
                } else if (data.error) {
                    toastr.error('Error: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Resend Error:', error);
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

