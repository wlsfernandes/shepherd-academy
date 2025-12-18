<form method="POST" action="<?php echo e(route('password.update')); ?>">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    
    <div class="row mb-3 align-items-center">
        <label class="col-lg-4 col-form-label">Current Password</label>
        <div class="col-lg-6">
            <input type="password" name="current_password" class="form-control" required>
        </div>
    </div>

    
    <div class="row mb-3 align-items-center">
        <label class="col-lg-4 col-form-label">New Password</label>
        <div class="col-lg-6">
            <input type="password" name="password" class="form-control" required>
        </div>
    </div>

    
    <div class="row mb-3 align-items-center">
        <label class="col-lg-4 col-form-label">Confirm Password</label>
        <div class="col-lg-6">
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
    </div>

    <button class="btn btn-primary">
        Update Password
    </button>
</form><?php /**PATH /var/www/html/passion2plant/resources/views/profile/partials/update-password-form.blade.php ENDPATH**/ ?>