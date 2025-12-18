<?php $__env->startSection('title', isset($user) ? 'Edit User' : 'Create User'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5><?php echo e(isset($user) ? 'Edit User' : 'Create User'); ?></h5>
            </div>

            <div class="card-body">
                <?php if (isset($component)) { $__componentOriginalb5e767ad160784309dfcad41e788743b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb5e767ad160784309dfcad41e788743b = $attributes; } ?>
<?php $component = App\View\Components\Alert::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Alert::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb5e767ad160784309dfcad41e788743b)): ?>
<?php $attributes = $__attributesOriginalb5e767ad160784309dfcad41e788743b; ?>
<?php unset($__attributesOriginalb5e767ad160784309dfcad41e788743b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb5e767ad160784309dfcad41e788743b)): ?>
<?php $component = $__componentOriginalb5e767ad160784309dfcad41e788743b; ?>
<?php unset($__componentOriginalb5e767ad160784309dfcad41e788743b); ?>
<?php endif; ?>

                <form method="POST"
                      action="<?php echo e(isset($user)
                        ? route('users.update', $user)
                        : route('users.store')); ?>">

                    <?php echo csrf_field(); ?>
                    <?php if(isset($user)): ?>
                        <?php echo method_field('PUT'); ?>
                    <?php endif; ?>

                    
                    <div class="row mb-3 align-items-center">
                        <label class="col-lg-2 col-form-label">Name</label>
                        <div class="col-lg-6">
                            <input name="name"
                                   class="form-control"
                                   value="<?php echo e(old('name', $user->name ?? '')); ?>"
                                   required>
                        </div>
                    </div>

                    
                    <div class="row mb-3 align-items-center">
                        <label class="col-lg-2 col-form-label">Email</label>
                        <div class="col-lg-6">
                            <input name="email"
                                   type="email"
                                   class="form-control"
                                   value="<?php echo e(old('email', $user->email ?? '')); ?>"
                                   required>
                        </div>
                    </div>

                    
                    <div class="row mb-3">
                        <label class="col-lg-2 col-form-label">Roles</label>
                        <div class="col-lg-6">
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="form-check mb-1">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="roles[]"
                                        value="<?php echo e($role->id); ?>"
                                        id="role_<?php echo e($role->id); ?>"
                                        <?php echo e(isset($user) && $user->roles->contains($role->id) ? 'checked' : ''); ?>

                                    >
                                    <label class="form-check-label" for="role_<?php echo e($role->id); ?>">
                                        <?php echo e($role->name); ?>

                                    </label>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <small class="text-muted">
                                Select one or more roles for this user.
                            </small>
                        </div>
                    </div>

                    
                    <div class="row mt-4">
                        <div class="col-lg-8 offset-lg-2">
                            <button class="btn btn-primary">
                                <?php echo e(isset($user) ? 'Update User' : 'Create User'); ?>

                            </button>

                            <a href="<?php echo e(route('users.index')); ?>" class="btn btn-light ms-2">
                                Cancel
                            </a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/passion2plant/resources/views/admin/users/form.blade.php ENDPATH**/ ?>