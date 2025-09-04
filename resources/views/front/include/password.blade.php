<!-- forget password modal -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content position-relative">
            <div class="modal-header border-0 pb-0 mb-5">
                <button type="button" class="btn bg-transparent modal-close-btn position-absolute" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body border-0 px-md-5">
                <div class="mb-md-4 d-flex flex-column align-items-center mb-2">
                    <img src="{{$front_ins_url.$front_icon_name}}" alt="Logo" class="logo-img mb-md-3 mb-2">
                    <h2 class="modal-title fs-4 fw-bold" id="loginModalLabel">Reset Your Account Password</h2>
                    <div class="resend-text">
                        No worries, we'll send you reset instructions.
                    </div>
                </div>

                <div id="forgot-password-error" class="alert alert-danger" style="display: none;"></div>

                <form id="forgotPasswordForm" method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-md-3 mb-2 text-start">
                        <label for="resetEmailInput" class="form-label">Email Address</label>
                        <input type="email" class="form-control py-3" id="resetEmailInput" name="email" value="{{ old('email') }}" placeholder="Your registered email" required autofocus>
                    </div>
                    <div class="mb-2 mb-md-4 text-center mb-2">
                        <button type="submit" id="sendResetLinkBtn" class="btn access-now-btn px-5">Send Reset OTP</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const forgotPasswordForm = document.getElementById('forgotPasswordForm');
    const sendBtn = document.getElementById('sendResetLinkBtn');
    const errorDiv = document.getElementById('forgot-password-error');

    if (forgotPasswordForm) {
        forgotPasswordForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            sendBtn.disabled = true;
            sendBtn.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Sending...`;
            errorDiv.style.display = 'none';

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: { 'Accept': 'application/json' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    toastr.success(data.message);
                    
                    // Close this modal
                    const forgotModalEl = document.getElementById('forgotPasswordModal');
                    const forgotModal = bootstrap.Modal.getInstance(forgotModalEl);
                    if (forgotModal) forgotModal.hide();

                    // Update and show OTP modal
                    document.getElementById('passwordChangeOtpEmail').textContent = formData.get('email');
                    const otpModal = new bootstrap.Modal(document.getElementById('resetModal'));
                    otpModal.show();
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
                sendBtn.disabled = false;
                sendBtn.innerHTML = 'Send Reset OTP';
            });
        });
    }
});
</script>
