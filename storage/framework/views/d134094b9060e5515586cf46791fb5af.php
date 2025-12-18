<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="<?php echo e(url('index')); ?>" class="logo logo-dark">
            <span class="logo-sm">
                <img src="<?php echo e(asset('/assets/admin/images/logos/small.png')); ?>" alt="" height="40">
            </span>
            <span class="logo-lg">
                <img src="<?php echo e(asset('/assets/admin/images/logos/small.png')); ?>" alt="" height="40">
            </span>
        </a>

        <a href="<?php echo e(url('index')); ?>" class="logo logo-light">
            <span class="logo-sm">
                <img src="<?php echo e(asset('/assets/admin/images/logos/small.png')); ?>" alt="" height="40">
            </span>
            <span class="logo-lg">
                <img src="<?php echo e(asset('/assets/admin/images/logo-light.png')); ?>" alt="" height="40">
            </span>
        </a>
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
        <i class="fa fa-fw fa-bars"></i>
    </button>

    <div data-simplebar class="sidebar-menu-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('access-admin')): ?>
                    <li>
                        <a href="#" class="has-arrow waves-effect" onclick="return false;">
                            <i class="uil-setting"></i>
                            <span>Administration</span>
                        </a>

                        <ul class="sub-menu" aria-expanded="false">

                            
                            <li>
                                <a href="<?php echo e(route('users.index')); ?>">
                                    <i class="uil-chat-bubble-user"></i> Users
                                </a>
                            </li>
                            
                            <li>
                                <a href="<?php echo e(route('roles.index')); ?>">
                                    <i class="uil-users-alt"></i> Roles
                                </a>
                            </li>

                            
                            <li>
                                <a href="<?php echo e(route('audits.index')); ?>">
                                    <i class="uil-history"></i> Audit Trail
                                </a>
                            </li>
                            
                            <li>
                                <a href="<?php echo e(url('system-logs')); ?>">
                                    <i class="uil uil-bug"></i> System Logs
                                </a>
                            </li>

                        </ul>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End --><?php /**PATH /var/www/html/passion2plant/resources/views/admin/layouts/sidebar.blade.php ENDPATH**/ ?>