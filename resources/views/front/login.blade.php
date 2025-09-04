@extends('front.master.master')
@section('title')
Login
@endsection

@section('css')

@endsection

@section('body')

<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
         <div class="col-md-6">
            <div class="mb-md-4 mb-2">
       
          <h2 class="modal-title fs-4 fw-bold" id="loginModalLabel">Hello Again! Please Log In</h2>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
          <div class="mb-md-3 mb-2 text-start">
            <label for="emailInput" class="form-label fw-bold">Email</label>
            <input type="email" name="email" class="form-control" id="emailInput" placeholder="example@gmail.com" required>
          </div>
          <div class="mb-md-3 mb-2 text-start">
            <label for="passwordInput" class="form-label fw-bold">Password</label>
            <input type="password" name="password" class="form-control" id="passwordInput" placeholder="Enter password" required>
          </div>
          <div class="d-flex justify-content-between align-items-center mb-2 mb-md-4">
            <div class="form-check custom-checkbox">
              <input class="form-check-input" type="checkbox" name="remember" id="remember">
              <label class="form-check-label" for="remember">
                Remember Me
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

          <div class="login-useful-link">
            <p class="mb-2">Don't have an account? <a href="#" class="text-decoration-none fw-bold community-link"
                data-bs-toggle="modal" data-bs-target="#staticBackdrop">Join the Community</a></p>

          </div>
        </form>
         </div>
          <div class="col-md-3"></div>
    </div>
</div>

   
@endsection

@section('script')
@endsection