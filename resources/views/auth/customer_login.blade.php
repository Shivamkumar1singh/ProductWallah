@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-lg rounded-4">

                <!-- Header -->
                <div class="card-header text-center fw-bold fs-4 rounded-top-4"
                     style="background-color: #000; color: #fff;">
                    <i class="bi bi-person-circle me-2"></i> {{ __('Login to Your Account') }}
                </div>

                <!-- Card Body -->
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('customer.login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="mb-4 position-relative">
                            <label for="email" class="form-label fw-bold text-dark">
                                <i class="bi bi-envelope-fill me-1"></i> {{ __('Email Address') }}
                            </label>
                            <input id="email"
                                   type="email"
                                   class="form-control form-control-lg shadow-sm rounded-pill ps-4 @error('email') is-invalid @enderror"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   autocomplete="email"
                                   autofocus
                                   placeholder="Enter your email address"
                                   style="font-weight: 600; color: #000;">
                            @error('email')
                                <div class="invalid-feedback d-block mt-2">
                                    <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-4 position-relative">
                            <label for="password" class="form-label fw-bold text-dark">
                                <i class="bi bi-lock-fill me-1"></i> {{ __('Password') }}
                            </label>
                            <div class="position-relative">
                                <input id="password"
                                       type="password"
                                       class="form-control form-control-lg shadow-sm rounded-pill ps-4 pe-5 @error('password') is-invalid @enderror"
                                       name="password"
                                       required
                                       autocomplete="current-password"
                                       placeholder="Enter your password"
                                       style="font-weight: 600; color: #000;">
                                <!-- Toggle Password -->
                                <span class="position-absolute top-50 end-0 translate-middle-y me-3"
                                      style="cursor: pointer;" id="togglePassword">
                                    <i class="bi bi-eye-slash fs-5 text-dark"></i>
                                </span>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block mt-2">
                                    <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Remember Me + Forgot Password -->
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="form-check ms-2">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="remember"
                                       id="remember"
                                       {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold text-dark" for="remember">
                                    <i class="bi bi-check2-square me-1 text-dark"></i> {{ __('Remember Me') }}
                                </label>
                            </div>

                            @if (Route::has('password.request'))
                                <a class="text-decoration-none fw-bold text-dark" href="{{ route('password.request') }}">
                                    <i class="bi bi-question-circle me-1"></i> {{ __('Forgot Password?') }}
                                </a>
                            @endif
                        </div>

                        <!-- Login Button -->
                        <div class="text-center">
                            <button type="submit"
                                    class="btn btn-dark btn-lg px-5 rounded-pill shadow-sm fw-bold">
                                <i class="bi bi-box-arrow-in-right me-2"></i> {{ __('Login') }}
                            </button>
                        </div>

                        <!-- Create an Account -->
                        <div class="text-center mt-4">
                            <p class="mb-0 text-dark fw-bold">
                                {{ __("Don't have an account?") }}
                                <a href="{{ route('customer.register') }}" class="text-decoration-none fw-bold text-dark hover-underline">
                                    <i class="bi bi-person-plus-fill me-1"></i> {{ __('Create one') }}
                                </a>
                            </p>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

<!-- Password Toggle Script -->
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const icon = togglePassword.querySelector('i');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;

            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        });
    });
</script>
@endpush
