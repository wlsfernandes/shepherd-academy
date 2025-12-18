<?php $__env->startSection('title', 'Audit Trail'); ?>

<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(asset('/assets/libs/datatables/datatables.min.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card border border-primary">
                <div class="card-header bg-transparent border-primary">
                    <h5 class="my-0 text-primary">
                        <i class="uil-history"></i> Audit Trail
                    </h5>
                </div>

                <div class="card-body">
                    <table id="datatable-audits" class="table table-striped table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>User</th>
                                <th>Action</th>
                                <th>Model</th>
                                <th>Record ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $audits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $audit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($loop->iteration); ?></td>
                                                        <td><?php echo e($audit->created_at->format('Y-m-d H:i:s')); ?></td>
                                                        <td><?php echo e($audit->user->name ?? 'System'); ?></td>
                                                        <td>
                                                            <span class="badge bg-<?php echo e(match ($audit->action) {
                                    'created' => 'success',
                                    'updated' => 'warning',
                                    'deleted' => 'danger',
                                    default => 'secondary'
                                }); ?>">
                                                                <?php echo e(strtoupper($audit->action)); ?>

                                                            </span>
                                                        </td>
                                                        <td><?php echo e(class_basename($audit->auditable_type)); ?></td>
                                                        <td><?php echo e($audit->auditable_id); ?></td>
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
            $('#datatable-audits').DataTable({
                order: [[1, 'desc']],
                pageLength: 25,
                lengthMenu: [[25, 50, 100, -1], [25, 50, 100, "All"]],
                dom: 'Bfrtip',
                buttons: ['excel', 'print']
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/passion2plant/resources/views/admin/audits/index.blade.php ENDPATH**/ ?>