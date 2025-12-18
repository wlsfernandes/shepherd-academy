<div>
    
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-start" role="alert">
            <div class="me-3 fs-4">
                <i class="uil uil-check-circle"></i>
            </div>
            <div>
                <strong>Success!</strong><br>
                <span><?php echo e(session('success')); ?></span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    
    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-start" role="alert">
            <div class="me-3 fs-4">
                <i class="uil uil-exclamation-triangle"></i>
            </div>
            <div>
                <strong>Something went wrong</strong><br>
                <span><?php echo e(session('error')); ?></span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    
    <?php if($errors->any()): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-start">
                <div class="me-3 fs-4">
                    <i class="uil uil-exclamation-circle"></i>
                </div>
                <div>
                    <strong>Please check the following:</strong>
                    <ul class="mb-0 mt-2">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

</div><?php /**PATH /var/www/html/passion2plant/resources/views/components/alert.blade.php ENDPATH**/ ?>