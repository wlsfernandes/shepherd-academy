<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <?php echo $__env->make('admin.layouts.title-meta', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('admin.layouts.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>

<?php $__env->startSection('body'); ?>

<body class="authentication-bg">
    <?php echo $__env->yieldSection(); ?>
    <?php echo $__env->yieldContent('content'); ?>
    <?php echo $__env->make('admin.layouts.vendor-scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>

</html><?php /**PATH /var/www/html/passion2plant/resources/views/admin/layouts/master-without-nav.blade.php ENDPATH**/ ?>