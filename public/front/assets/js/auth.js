// Authentication handling for Pick N Drop
class AuthHandler {
    constructor() {
        this.apiBase = '/api';
        this.init();
    }

    init() {
        this.setupLoginForm();
        this.setupRegistrationForm();
        this.setupOtpForm();
        this.setupPasswordResetForm();
    }

    // Setup login form
    setupLoginForm() {
        const loginForm = document.querySelector('#loginModal form');
        if (loginForm) {
            loginForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                await this.handleLogin();
            });
        }
    }

    // Setup registration form
    setupRegistrationForm() {
        const registerForm = document.querySelector('#staticBackdrop form');
        if (registerForm) {
            registerForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                await this.handleRegistration();
            });
        }
    }

    // Setup OTP form
    setupOtpForm() {
        const otpForm = document.querySelector('#otpModal form');
        if (otpForm) {
            otpForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                await this.handleOtpVerification();
            });
        }

        // Setup OTP input behavior
        this.setupOtpInputs();
        
        // Setup resend OTP
        const resendBtn = document.getElementById('resendOtp');
        if (resendBtn) {
            resendBtn.addEventListener('click', async (e) => {
                e.preventDefault();
                await this.handleResendOtp();
            });
        }
    }

    // Setup password reset form
    setupPasswordResetForm() {
        const resetForm = document.querySelector('#forgotPasswordModal form');
        if (resetForm) {
            resetForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                await this.handlePasswordReset();
            });
        }
    }

    // Handle login
    async handleLogin() {
        const email = document.getElementById('emailInput')?.value;
        const password = document.getElementById('passwordInput')?.value;
        const accountType = document.querySelector('.account-btn.active')?.dataset.account || 'customer';

        if (!email || !password) {
            this.showAlert('Please fill in all fields', 'error');
            return;
        }

        try {
            this.showLoading('Logging in...');
            
            const response = await fetch(`${this.apiBase}/login`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    email,
                    password,
                    account_type: accountType
                })
            });

            const data = await response.json();

            if (response.ok) {
                // Store token
                localStorage.setItem('auth_token', data.token);
                localStorage.setItem('user', JSON.stringify(data.user));
                
                this.showAlert('Login successful!', 'success');
                
                // Close modal and redirect
                setTimeout(() => {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
                    if (modal) modal.hide();
                    window.location.href = 'profile.html';
                }, 1500);
            } else {
                this.showAlert(data.message || 'Login failed', 'error');
            }
        } catch (error) {
            console.error('Login error:', error);
            this.showAlert('Network error. Please try again.', 'error');
        } finally {
            this.hideLoading();
        }
    }

    // Handle registration
    async handleRegistration() {
        const formData = this.getRegistrationFormData();
        
        if (!this.validateRegistrationData(formData)) {
            return;
        }

        try {
            this.showLoading('Creating account...');
            
            // First, request OTP
            const otpResponse = await fetch(`${this.apiBase}/otp/request`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    email: formData.email
                })
            });

            const otpData = await otpResponse.json();

            if (otpResponse.ok) {
                // Store registration data for OTP verification
                sessionStorage.setItem('registration_data', JSON.stringify(formData));
                
                // Show OTP modal
                const loginModal = bootstrap.Modal.getInstance(document.getElementById('staticBackdrop'));
                if (loginModal) loginModal.hide();
                
                const otpModal = new bootstrap.Modal(document.getElementById('otpModal'));
                otpModal.show();
                
                // Update OTP modal with email
                const otpEmailElement = document.querySelector('#otpModal .otp-container p strong');
                if (otpEmailElement) {
                    otpEmailElement.textContent = formData.email;
                }
                
                this.showAlert('OTP sent to your email!', 'success');
            } else {
                this.showAlert(otpData.message || 'Failed to send OTP', 'error');
            }
        } catch (error) {
            console.error('Registration error:', error);
            this.showAlert('Network error. Please try again.', 'error');
        } finally {
            this.hideLoading();
        }
    }

    // Setup OTP input behavior
    setupOtpInputs() {
        const otpInputs = document.querySelectorAll('#otpModal .otp-input');
        
        otpInputs.forEach((input, index) => {
            // Handle input
            input.addEventListener('input', (e) => {
                const value = e.target.value;
                if (value.length === 1 && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
            });

            // Handle backspace
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    otpInputs[index - 1].focus();
                }
            });

            // Handle paste
            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pastedData = e.clipboardData.getData('text').slice(0, 4);
                if (/^\d{4}$/.test(pastedData)) {
                    otpInputs.forEach((input, i) => {
                        input.value = pastedData[i] || '';
                    });
                    otpInputs[3].focus();
                }
            });
        });
    }

    // Handle resend OTP
    async handleResendOtp() {
        const registrationData = JSON.parse(sessionStorage.getItem('registration_data') || '{}');
        
        if (!registrationData.email) {
            this.showAlert('Registration data not found. Please try again.', 'error');
            return;
        }

        try {
            this.showLoading('Resending OTP...');
            
            const response = await fetch(`${this.apiBase}/otp/request`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    email: registrationData.email
                })
            });

            const data = await response.json();

            if (response.ok) {
                this.showAlert('OTP resent successfully!', 'success');
                
                // Clear OTP inputs
                const otpInputs = document.querySelectorAll('#otpModal .otp-input');
                otpInputs.forEach(input => input.value = '');
                otpInputs[0].focus();
            } else {
                this.showAlert(data.message || 'Failed to resend OTP', 'error');
            }
        } catch (error) {
            console.error('Resend OTP error:', error);
            this.showAlert('Network error. Please try again.', 'error');
        } finally {
            this.hideLoading();
        }
    }

    // Handle OTP verification
    async handleOtpVerification() {
        const otpInputs = document.querySelectorAll('#otpModal .otp-input');
        const otpCode = Array.from(otpInputs).map(input => input.value).join('');
        const registrationData = JSON.parse(sessionStorage.getItem('registration_data') || '{}');

        if (!registrationData.email) {
            this.showAlert('Registration data not found. Please try again.', 'error');
            return;
        }

        try {
            this.showLoading('Verifying OTP...');
            
            const response = await fetch(`${this.apiBase}/otp/verify`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    email: registrationData.email,
                    code: otpCode,
                    name: registrationData.name,
                    password: registrationData.password,
                    phone: registrationData.phone,
                    address: registrationData.address,
                    city: registrationData.city,
                    state: registrationData.state,
                    postal_code: registrationData.postal_code,
                    country: registrationData.country
                })
            });

            const data = await response.json();

            if (response.ok) {
                // Store token
                localStorage.setItem('auth_token', data.token);
                localStorage.setItem('user', JSON.stringify(data.user));
                
                // Clear registration data
                sessionStorage.removeItem('registration_data');
                
                this.showAlert('Account created successfully!', 'success');
                
                // Close modal and redirect
                setTimeout(() => {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('otpModal'));
                    if (modal) modal.hide();
                    window.location.href = 'profile.html';
                }, 1500);
            } else {
                this.showAlert(data.message || 'OTP verification failed', 'error');
            }
        } catch (error) {
            console.error('OTP verification error:', error);
            this.showAlert('Network error. Please try again.', 'error');
        } finally {
            this.hideLoading();
        }
    }

    // Handle password reset
    async handlePasswordReset() {
        const email = document.getElementById('resetEmailInput')?.value;

        if (!email) {
            this.showAlert('Please enter your email', 'error');
            return;
        }

        try {
            this.showLoading('Sending reset link...');
            
            const response = await fetch(`${this.apiBase}/password/email`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ email })
            });

            const data = await response.json();

            if (response.ok) {
                this.showAlert('Password reset link sent to your email!', 'success');
            } else {
                this.showAlert(data.message || 'Failed to send reset link', 'error');
            }
        } catch (error) {
            console.error('Password reset error:', error);
            this.showAlert('Network error. Please try again.', 'error');
        } finally {
            this.hideLoading();
        }
    }

    // Get registration form data
    getRegistrationFormData() {
        const accountType = document.querySelector('.account-btn.active')?.dataset.account || 'customer';
        
        return {
            name: document.querySelector('#staticBackdrop input[placeholder="Enter full name"]')?.value,
            email: document.querySelector('#staticBackdrop input[placeholder="example@gmail.com"]')?.value,
            phone: document.querySelector('#staticBackdrop input[placeholder="Enter Phone Number"]')?.value,
            address: document.querySelector('#staticBackdrop input[placeholder="Address"]')?.value,
            country: document.querySelector('#staticBackdrop select:first-of-type')?.value,
            city: document.querySelector('#staticBackdrop select:nth-of-type(2)')?.value,
            state: document.querySelector('#staticBackdrop input[placeholder="Enter State"]')?.value,
            postal_code: document.querySelector('#staticBackdrop input[placeholder="Zip Code"]')?.value,
            password: document.getElementById('newPassword')?.value,
            confirm_password: document.getElementById('confirmPassword')?.value,
            account_type: accountType
        };
    }

    // Validate registration data
    validateRegistrationData(data) {
        if (!data.name || !data.email || !data.phone || !data.address || !data.country || 
            !data.city || !data.state || !data.postal_code || !data.password || !data.confirm_password) {
            this.showAlert('Please fill in all required fields', 'error');
            return false;
        }

        if (data.password !== data.confirm_password) {
            this.showAlert('Passwords do not match', 'error');
            return false;
        }

        if (data.password.length < 8) {
            this.showAlert('Password must be at least 8 characters long', 'error');
            return false;
        }

        return true;
    }

    // Show alert
    showAlert(message, type = 'info') {
        // Remove existing alerts
        const existingAlert = document.querySelector('.auth-alert');
        if (existingAlert) {
            existingAlert.remove();
        }

        // Create alert element
        const alert = document.createElement('div');
        alert.className = `alert alert-${type === 'error' ? 'danger' : type} auth-alert position-fixed`;
        alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        alert.textContent = message;

        // Add to body
        document.body.appendChild(alert);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    }

    // Show loading
    showLoading(message = 'Loading...') {
        // Remove existing loading
        this.hideLoading();

        // Create loading element
        const loading = document.createElement('div');
        loading.id = 'auth-loading';
        loading.className = 'position-fixed d-flex align-items-center justify-content-center';
        loading.style.cssText = 'top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999;';
        
        loading.innerHTML = `
            <div class="spinner-border text-light me-2" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <span class="text-light">${message}</span>
        `;

        // Add to body
        document.body.appendChild(loading);
    }

    // Hide loading
    hideLoading() {
        const loading = document.getElementById('auth-loading');
        if (loading) {
            loading.remove();
        }
    }

    // Check if user is logged in
    isLoggedIn() {
        return !!localStorage.getItem('auth_token');
    }

    // Get current user
    getCurrentUser() {
        const user = localStorage.getItem('user');
        return user ? JSON.parse(user) : null;
    }

    // Logout
    logout() {
        localStorage.removeItem('auth_token');
        localStorage.removeItem('user');
        window.location.href = 'index.html';
    }
}

// Initialize auth handler when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.authHandler = new AuthHandler();
});

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = AuthHandler;
}
