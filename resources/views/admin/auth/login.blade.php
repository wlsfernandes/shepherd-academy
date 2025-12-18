@extends('admin.layouts.master-without-nav')

@section('title')
    Login
@endsection

@section('content')
<div class="account-pages my-5 pt-sm-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <a href="{{ secure_url('index') }}" class="mb-5 d-block auth-logo">
                        <img src="{{ asset('/assets/admin/images/logos/light.png') }}" alt="" class="logo logo-light">
                        <img src="{{ asset('/assets/admin/images/logos/light.png') }}" alt="" class="logo logo-light">
                    </a>
                </div>
            </div>
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="text-center mt-2">
                            <h5 style="color:#4a235a">Welcome Back !</h5>
                            <p class="text-muted">Sign in to continue to devpromaster admin.</p>
                        </div>
                        <div class="p-2 mt-4">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" id="email"
                                        placeholder="Enter Email address">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <div class="float-end">
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}" class="text-muted">Forgot
                                                password?</a>
                                        @endif
                                    </div>
                                    <label class="form-label" for="userpassword">Password</label>
                                    <div class="input-group">
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            id="userpassword" placeholder="Enter password">
                                        <span class="input-group-text" id="toggle-password">
                                            <i class="fas fa-eye" id="toggle-icon"></i>
                                        </span>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!--      <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="auth-remember-check" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                </div> -->

                                <div class="mt-3 text-end">
                                    <button class="btn btn-primary w-sm waves-effect waves-light"
                                        style="background: linear-gradient(to right,#4a235a, #a569bd, #e8daef); border-color: #4a235a; color: #fff;"
                                        type="submit">Log
                                        In</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="mt-5 text-center">
                    <p>
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                        © devpromaster all rights reserved
                    </p>
                    <p>#somos <i class="mdi mdi-heart text-danger"></i> devpromaster.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add JavaScript for toggling password visibility -->
<script>
    document.getElementById('toggle-password').addEventListener('click', function () {
        var passwordField = document.getElementById('userpassword');
        var toggleIcon = document.getElementById('toggle-icon');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    });
</script>