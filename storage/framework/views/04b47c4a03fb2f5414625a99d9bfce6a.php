<form method="POST" action="<?php echo e(route('profile.update')); ?>">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PATCH'); ?>

    
    <div class="row mb-3 align-items-center">
        <label class="col-lg-3 col-form-label">Name</label>
        <div class="col-lg-7">
            <input name="name" class="form-control" value="<?php echo e(old('name', $user->name)); ?>" required>
        </div>
    </div>

    
    <div class="row mb-3 align-items-center">
        <label class="col-lg-3 col-form-label">Email</label>
        <div class="col-lg-7">
            <input name="email" type="email" class="form-control" value="<?php echo e(old('email', $user->email)); ?>" required>
        </div>
    </div>

    <?php if($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail()): ?>
        <div class="alert alert-warning">
            Your email address is not verified.
        </div>
    <?php endif; ?>

    <button class="btn btn-primary">
        Save Changes
    </button>
</form><?php /**PATH /var/www/html/passion2plant/resources/views/profile/partials/update-profile-information-form.blade.php ENDPATH**/ ?>