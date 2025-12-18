<?php $__env->startSection('title'); ?>
    Login
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="account-pages my-5 pt-sm-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <a href="<?php echo e(secure_url('index')); ?>" class="mb-5 d-block auth-logo">
                        <img src="<?php echo e(asset('/assets/admin/images/logos/light.png')); ?>" alt="" class="logo logo-light">
                        <img src="<?php echo e(asset('/assets/admin/images/logos/light.png')); ?>" alt="" class="logo logo-light">
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
                            <form method="POST" action="<?php echo e(route('login')); ?>">
                                <?php echo csrf_field(); ?>

                                <div class="mb-3">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        name="email" value="<?php echo e(old('email')); ?>" id="email"
                                        placeholder="Enter Email address">
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mb-3">
                                    <div class="float-end">
                                        <?php if(Route::has('password.request')): ?>
                                            <a href="<?php echo e(route('password.request')); ?>" class="text-muted">Forgot
                                                password?</a>
                                        <?php endif; ?>
                                    </div>
                                    <label class="form-label" for="userpassword">Password</label>
                                    <div class="input-group">
                                        <input type="password"
                                            class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password"
                                            id="userpassword" placeholder="Enter password">
                                        <span class="input-group-text" id="toggle-password">
                                            <i class="fas fa-eye" id="toggle-icon"></i>
                                        </span>
                                    </div>
                                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <!--      <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="auth-remember-check" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
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
<?php echo $__env->make('admin.layouts.master-without-nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/passion2plant/resources/views/admin/auth/login.blade.php ENDPATH**/ ?>