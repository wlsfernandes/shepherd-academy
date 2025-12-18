<?php $__env->startSection('title', 'System Logs'); ?>

<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(asset('/assets/libs/datatables/datatables.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card border border-primary">
                <div class="card-header bg-transparent border-primary">
                    <h5 class="my-0 text-primary">
                        <i class="uil uil-bug"></i> System Logs
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

                    <table id="datatable-logs" class="table table-striped table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>User</th>
                                <th>Level</th>
                                <th>Action</th>
                                <th>Message</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($loop->iteration); ?></td>
                                                    <td><?php echo e($log->created_at->format('Y-m-d H:i')); ?></td>
                                                    <td><?php echo e($log->user->name ?? 'System'); ?></td>
                                                    <td>
                                                        <span
                                                            class="badge bg-<?php echo e(match ($log->level) {
                                    'critical' => 'danger',
                                    'error' => 'danger',
                                    'warning' => 'warning',
                                    default => 'secondary'
                                }); ?>">
                                                            <?php echo e(strtoupper($log->level)); ?>

                                                        </span>
                                                    </td>
                                                    <td><?php echo e($log->action ?? '-'); ?></td>
                                                    <td style="max-width:300px; white-space: normal;">
                                                        <?php echo e($log->message); ?>

                                                    </td>
                                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('/assets/libs/datatables/datatables.min.js')); ?>"></script>
    <script>
        $(function () {
            $('#datatable-logs').DataTable({
                order: [[1, 'desc']],
                pageLength: 25,
                lengthMenu: [[25, 50, 100, -1], [25, 50, 100, "All"]],
                dom: 'Bfrtip',
                buttons: ['excel', 'print']
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/passion2plant/resources/views/admin/system-logs/index.blade.php ENDPATH**/ ?>