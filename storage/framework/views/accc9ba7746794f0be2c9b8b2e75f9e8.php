<?php $__env->startSection('title', 'Events'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card border border-primary">
        <div class="card-header d-flex justify-content-between">
            <h5>
                <i class="uil-calendar-alt"></i> Events
            </h5>
            <a href="<?php echo e(route('events.create')); ?>" class="btn btn-success">
                <i class="uil-plus"></i> Add Event
            </a>
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

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title (EN)</th>
                        <th>Event Date</th>
                        <th>Image</th>
                        <th>File En</th>
                        <th>File Es</th>
                        <th>Published</th>
                        <th>Publication Window</th>
                        <th width="140">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <strong><?php echo e($event->title_en); ?></strong><br>
                                <small class="text-muted"><?php echo e($event->slug); ?></small>
                            </td>

                            <td>
                                <?php echo e($event->event_date?->format('M d, Y') ?? '-'); ?>

                            </td>
                            <td class="text-center"><a
                                    href="<?php echo e(route('admin.images.edit', ['model' => 'event', 'id' => $event->id])); ?>"
                                    title="Upload / Edit image" class="me-2">
                                    <i class="uil-image font-size-22 <?php echo e($event->image_url ? 'text-primary' : 'text-muted'); ?>">
                                    </i>
                                </a>
                                <?php if($event->image_url): ?>
                                                    <a href="<?php echo e(route('admin.images.preview', [
                                        'model' => 'event',
                                        'id' => $event->id
                                    ])); ?>" title="View image" target="_blank">
                                                        <i class="fas fa-eye font-size-6 text-primary"></i>
                                </a><?php else: ?> <i class="fas fa-eye font-size-6 text-muted"></i>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="<?php echo e(route('admin.files.edit', ['model' => 'event', 'id' => $event->id, 'lang' => 'en'])); ?>"
                                    title="Upload / Edit English file" class="me-2">
                                    <i class="uil-file font-size-22 <?php echo e($event->file_url_en ? 'text-primary' : 'text-muted'); ?>">
                                    </i>
                                </a>
                                <?php if($event->file_url_en): ?>
                                    <a href="<?php echo e(route('admin.files.download', ['model' => 'event', 'id' => $event->id, 'lang' => 'en'])); ?>"
                                title="Download English file"><i class="fas fa-eye font-size-6 text-primary"></i></a><?php else: ?>
                                        <i class="fas fa-eye font-size-6 text-muted"></i>

                                    <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="<?php echo e(route('admin.files.edit', ['model' => 'event', 'id' => $event->id, 'lang' => 'es'])); ?>"
                                    title="Upload Spanish file">
                                    <i class="uil-file font-size-22 <?php echo e($event->file_url_es ? 'text-primary' : 'text-muted'); ?>">
                                    </i>
                                </a>
                                <?php if($event->file_url_es): ?><a
                                    href="<?php echo e(route('admin.files.download', ['model' => 'event', 'id' => $event->id, 'lang' => 'es'])); ?>"
                                    title="Download Spanish file">
                                    <i class="fas fa-eye font-size-6 text-primary"></i>
                                </a><?php else: ?>
                                    <i class="fas fa-eye font-size-6 text-muted"></i>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if($event->is_published): ?>
                                    <span class="badge bg-success">Yes</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">No</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <small>
                                    From:
                                    <?php echo e($event->publish_start_at?->format('M d, Y') ?? '-'); ?><br>
                                    To:
                                    <?php echo e($event->publish_end_at?->format('M d, Y') ?? '-'); ?>

                                </small>
                            </td>

                            <td>
                                <a href="<?php echo e(route('events.edit', $event)); ?>" class="btn btn-sm btn-warning">
                                    <i class="uil-pen"></i>
                                </a>

                                <form action="<?php echo e(route('events.destroy', $event)); ?>" method="POST" class="d-inline"
                                    onsubmit="return confirm('Delete this event?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-sm btn-danger">
                                        <i class="uil-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                No events found.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/passion2plant/resources/views/admin/events/index.blade.php ENDPATH**/ ?>