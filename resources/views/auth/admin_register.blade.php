@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-lg rounded-4">
                <!-- 🟣 Header -->
                <div class="card-header text-center text-white fw-bold fs-4 rounded-top-4"
                     style="background: linear-gradient(135deg, #007bff, #6610f2);">
                    <i class="bi bi-person-plus-fill me-2"></i> {{ __('Register') }}
                </div>

                <!-- 🧾 Card Body -->
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.register') }}">
                        @csrf

                        <!-- 🧍 Name -->
                        <div class="mb-4 position-relative">
                            <label for="name" class="form-label fw-semibold text-primary">
                                <i class="bi bi-person-fill me-1"></i> {{ __('Name') }}
                            </label>
                            <input id="name" 
                                   type="text" 
                                   class="form-control form-control-lg shadow-sm rounded-pill ps-4 @error('name') is-invalid @enderror" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required 
                                   autocomplete="name" 
                                   autofocus
                                   placeholder="Enter your full name">
                            @error('name')
                                <div class="invalid-feedback d-block mt-2">
                                    <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- 📧 Email -->
                        <div class="mb-4 position-relative">
                            <label for="email" class="form-label fw-semibold text-primary">
                                <i class="bi bi-envelope-fill me-1"></i> {{ __('Email Address') }}
                            </label>
                            <input id="email" 
                                   type="email" 
                                   class="form-control form-control-lg shadow-sm rounded-pill ps-4 @error('email') is-invalid @enderror" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autocomplete="email"
                                   placeholder="Enter your email address">
                            @error('email')
                                <div class="invalid-feedback d-block mt-2">
                                    <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- 🔒 Password -->
                        <div class="mb-4 position-relative">
                            <label for="password" class="form-label fw-semibold text-primary">
                                <i class="bi bi-lock-fill me-1"></i> {{ __('Password') }}
                            </label>
                            <div class="position-relative">
                                <input id="password" 
                                       type="password" 
                                       class="form-control form-control-lg shadow-sm rounded-pill ps-4 pe-5 @error('password') is-invalid @enderror" 
                                       name="password" 
                                       required 
                                       autocomplete="new-password"
                                       placeholder="Create a password">
                                <!-- 👁️ Toggle Password -->
                                <span class="position-absolute top-50 end-0 translate-middle-y me-3" 
                                      id="togglePassword" style="cursor: pointer;">
                                    <i class="bi bi-eye-slash fs-5 text-muted"></i>
                                </span>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block mt-2">
                                    <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- ✅ Confirm Password -->
                        <div class="mb-4 position-relative">
                            <label for="password-confirm" class="form-label fw-semibold text-primary">
                                <i class="bi bi-shield-lock-fill me-1"></i> {{ __('Confirm Password') }}
                            </label>
                            <div class="position-relative">
                                <input id="password-confirm" 
                                       type="password" 
                                       class="form-control form-control-lg shadow-sm rounded-pill ps-4 pe-5" 
                                       name="password_confirmation" 
                                       required 
                                       autocomplete="new-password"
                                       placeholder="Confirm your password">
                                <!-- 👁️ Toggle Confirm Password -->
                                <span class="position-absolute top-50 end-0 translate-middle-y me-3" 
                                      id="toggleConfirmPassword" style="cursor: pointer;">
                                    <i class="bi bi-eye-slash fs-5 text-muted"></i>
                                </span>
                            </div>
                        </div>

                        <!-- 🚀 Register Button -->
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary px-5 py-2 rounded-pill shadow-sm">
                                <i class="bi bi-person-check-fill me-1"></i> {{ __('Register') }}
                            </button>
                        </div>

                        <!-- 🔁 Already Have an Account -->
                        <div class="text-center mt-3">
                            <p class="mb-0 text-muted">
                                {{ __("Already have an account?") }}
                                <a href="{{ route('login') }}" class="text-decoration-none fw-semibold text-primary hover-underline">
                                    <i class="bi bi-box-arrow-in-right me-1"></i> {{ __('Login here') }}
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

<!-- 👁️ Password Toggle Script -->
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    function setupToggle(toggleId, inputId) {
        const toggle = document.getElementById(toggleId);
        const input = document.getElementById(inputId);
        const icon = toggle.querySelector('i');

        toggle.addEventListener('click', function () {
            const type = input.type === 'password' ? 'text' : 'password';
            input.type = type;
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        });
    }

    setupToggle('togglePassword', 'password');
    setupToggle('toggleConfirmPassword', 'password-confirm');
});
</script>
@endpush
