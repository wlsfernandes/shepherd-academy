<?php $__env->startSection('title', isset($role) ? 'Edit Role' : 'Create Role'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-8">
        <div class="card border border-primary">
            <div class="card-header">
                <h5>
                    <i class="uil-users-alt"></i>
                    <?php echo e(isset($role) ? 'Edit Role' : 'Create Role'); ?>

                </h5>
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
                      action="<?php echo e(isset($role)
                        ? route('roles.update', $role)
                        : route('roles.store')); ?>">

                    <?php echo csrf_field(); ?>
                    <?php if(isset($role)): ?>
                        <?php echo method_field('PUT'); ?>
                    <?php endif; ?>

                    
                    <div class="row mb-3 align-items-center">
                        <label class="col-lg-3 col-form-label">Role Name</label>
                        <div class="col-lg-6">
                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                value="<?php echo e(old('name', $role->name ?? '')); ?>"
                                required
                                <?php echo e(isset($role) && $role->name === 'Admin' ? 'readonly' : ''); ?>

                            >

                            <?php if(isset($role) && $role->name === 'Admin'): ?>
                                <small class="text-muted">
                                    The Admin role cannot be modified.
                                </small>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="row mt-4">
                        <div class="col-lg-9 offset-lg-3">
                            <button class="btn btn-primary">
                                <?php echo e(isset($role) ? 'Update Role' : 'Create Role'); ?>

                            </button>

                            <a href="<?php echo e(route('roles.index')); ?>"
                               class="btn btn-light ms-2">
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

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/passion2plant/resources/views/admin/roles/form.blade.php ENDPATH**/ ?>