<form method="POST" action="<?php echo e(route('profile.destroy')); ?>"
    onsubmit="return confirm('This action is permanent. Are you sure?')">

    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>

    <p class="text-danger mb-3">
        Once your account is deleted, all of its resources and data will be permanently removed.
    </p>

    <div class="row mb-3 align-items-center">
        <label class="col-lg-4 col-form-label">Confirm Password</label>
        <div class="col-lg-6">
            <input type="password" name="password" class="form-control" required>
        </div>
    </div>

    <button class="btn btn-danger">
        Delete My Account
    </button>
</form><?php /**PATH /var/www/html/passion2plant/resources/views/profile/partials/delete-user-form.blade.php ENDPATH**/ ?>