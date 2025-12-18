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
                <li class="menu-title"><?php echo app('translator')->get('translation.Menu'); ?></li>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('access-advisor')): ?>
                    <li>
                        <a href="<?php echo e(url('advisor-docs')); ?>"><i class="far fa-file-pdf"></i>Documents</a>
                    </li>
                    <li>
                        <a href="<?php echo e(url('advisor')); ?>"><i class="uil-comments-alt"></i>Advisor</a>
                    </li>
                    <ul class="sub-menu" aria-expanded="false">

                        <!-- Year 2025 -->
                        <li>
                            <a class="has-arrow waves-effect"><i class="uil-calendar-alt"></i>2025</a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="<?php echo e(url('advisor/2025')); ?>"><i class="uil-comments-alt"></i>Applications</a>
                                </li>
                                <li><a href="<?php echo e(url('advisorMidTermEvaluation/2025')); ?>"><i
                                            class="uil-file-info-alt"></i>Mid Terms</a>
                                </li>
                                <li><a href="<?php echo e(url('advisorFinalEvaluation/2025')); ?>"><i
                                            class="uil-file-bookmark-alt"></i>Final
                                        Reports</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('access-capacity')): ?>
                    <li>
                        <a href="<?php echo e(url('index')); ?>">
                            <i class="uil-dashboard"></i>
                            <span><?php echo app('translator')->get('translation.Dashboard'); ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(url('enrollment')); ?>">
                            <i class="uil-play"></i>
                            <span>Enrollment</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(url('proposal')); ?>">
                            <i class="uil-pen"></i>
                            <span>Proposal</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(url('board')); ?>">
                            <i class="uil-paperclip"></i>
                            <span>Governing Board</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(url('budget')); ?>">
                            <i class="uil-paperclip"></i>
                            <span>Budget</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(url('w9')); ?>">
                            <i class="uil-paperclip"></i>
                            <span>W9 Form</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(url('achDirect')); ?>">
                            <i class="uil-paperclip"></i>
                            <span>ACH Deposit Form</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(url('finish')); ?>">
                            <i class="fas fa-flag-checkered "></i>
                            <span>Finish</span>
                        </a>
                    </li>
                    <li class="menu-title"><i class="uil-dashboard">Reports</i></li>
                    <li>
                        <a href="<?php echo e(url('midTermReport')); ?>">
                            <i class="uil-paperclip"></i>
                            <span>Mid-Term</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(url('finalReport')); ?>">
                            <i class="uil-paperclip"></i>
                            <span>Final Report</span>
                        </a>
                    </li>
                    <li class="menu-title"><i class="uil-dashboard">Monitor</i></li>
                    <li>
                        <a href="<?php echo e(url('problem')); ?>">
                            <i class="uil-ticket"></i>
                            <span>Problems</span>
                        </a>
                    </li>

                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['access-admin', 'access-developer', 'access-jcgrc', 'access-certification', 'access-employee'])): ?>
                    <li class="menu-title"><i class="uil-dashboard"></i> Apps</li>

                    <li>
                        <a href="#" class="has-arrow waves-effect" onclick="return false;">
                            <i class="dripicons-to-do"></i>
                            <span>Employee Area</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="<?php echo e(url('calendar')); ?>" class="waves-effect">
                                    <i class="uil-calendar-alt"></i>
                                    <span>devpromaster Calendar</span>
                                </a>
                            </li>
                            <ul class="sub-menu" aria-expanded="false">
                                <li>
                                    <a href="#" class="has-arrow waves-effect">
                                        <i class="uil uil-monitor-heart-rate"></i>
                                        <span>Reports</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <li>
                                            <a href="<?php echo e(url('timeWorkReport')); ?>"><i class="uil-clock-nine"></i>Time Work
                                                Report</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(route('timeWorkQuarterlyReport.index')); ?>"><i
                                                    class="fab fa-page4"></i>
                                                Quarterly Report</a>
                                        </li>
                                    </ul>
                                </li>

                            </ul>

                            <li>
                                <a href="<?php echo e(url('wikipedia')); ?>"><i class="dripicons-help"></i></i>System Helper</a>
                            </li>
                            <ul class="sub-menu" aria-expanded="false">
                                <li>
                                    <a href="#" class="has-arrow waves-effect">
                                        <i class="uil uil-ticket"></i>
                                        <span>Tickets</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <li>
                                            <a href="<?php echo e(url('ticket')); ?>"><i class="uil-ticket text-success"></i>Open</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(route('getClosedTicket')); ?>"><i
                                                    class="uil-ticket text-danger"></i>Closed</a>
                                        </li>
                                    </ul>
                                </li>

                            </ul>


                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['access-admin', 'access-developer', 'access-web-mkt-sm'])): ?>
                    <li>
                        <a href="#" class="has-arrow waves-effect" onclick="return false;">
                            <i class="dripicons-browser"></i>
                            <span>Website Admin</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="#" class="has-arrow waves-effect">
                                    <i class="uil uil-user"></i>
                                    <span>Members</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li>
                                        <a href="<?php echo e(url('member')); ?>">
                                            <i class="uil-users-alt"></i>All
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo e(url('active-members')); ?>">
                                            <i class="uil-user-check text-success"></i>Active
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo e(url('to-expire-members')); ?>" class="text-warning">
                                            <i class="uil-user-exclamation text-warning"></i>To Expire
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo e(url('inactive-members')); ?>">
                                            <i class="uil-user-times text-danger"></i>Expired
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo e(url('portalContent')); ?>">
                                            <i class="uil uil-gift"></i>Exclusive Content
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo e(url('access-report-portal')); ?>">
                                            <i class="uil-history text-info"></i>Portal Access
                                        </a>
                                    </li>
                                </ul>

                            </li>
                            <li>
                                <a href="#" class="has-arrow waves-effect">
                                    <i class="dripicons-store"></i>
                                    <span>Bookstore</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li>
                                        <a href="<?php echo e(url('product')); ?>">
                                            <i class="uil-books"></i>Products
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo e(url('ebook')); ?>">
                                            <i class="uil-notebooks"></i>E-Books
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo e(url('order')); ?>">
                                            <i class="uil-box"></i>Orders
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo e(url('category')); ?>">
                                            <i class="uil uil-list-ul"></i>Category
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="has-arrow waves-effect">
                                    <i class="fas fa-share-alt"></i> 
                                    <span>Social Media</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li>
                                        <a href="<?php echo e(url('eblast')); ?>">
                                            <i class="fas fa-envelope-open-text"></i> 
                                            Eblast
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo e(url('facebook')); ?>">
                                            <i class="fab fa-facebook-square"></i>
                                            Facebook
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo e(url('instagram')); ?>">
                                            <i class="fab fa-instagram"></i>
                                            Instagram
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo e(url('youtube')); ?>">
                                            <i class="fab fa-youtube"></i>
                                            YouTube
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="has-arrow waves-effect">
                                    <i class="uil uil-credit-card"></i> 
                                    <span>Payments</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li>
                                        <a href="<?php echo e(url('reports/stripe')); ?>">
                                            <i class="bx bxl-stripe"></i>Stripe
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo e(url('payment')); ?>">
                                            <i class="uil uil-credit-card"></i>Payments
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="<?php echo e(url('post')); ?>">
                                    <i class="uil-blogger-alt"></i>Blog
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(url('file')); ?>">
                                    <i class="fab fa-amazon"></i>S3 Upload Files
                                </a>
                            </li>

                            <li>
                                <a href="<?php echo e(url('error-logs')); ?>">
                                    <i class="uil uil-bug"></i>Error Logs
                                </a>
                            </li>

                        </ul>
                    </li>

                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['access-admin', 'access-developer', 'access-web-mkt-sm'])): ?>
                    <li class="has-submenu">
                        <a href="#" class="has-arrow waves-effect">
                            <i class="dripicons-print"></i>
                            <span>Reports</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">

                            <!-- Visitors Section -->
                            <li class="has-submenu">
                                <a href="#" class="has-arrow waves-effect">
                                    <i class="fab fa-instagram"></i>
                                    <span>WebSite SM</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li>
                                        <a href="<?php echo e(route('totalDataVisitors')); ?>">
                                            <i class="fas fa-chart-bar"></i> Monthly
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <!-- Real Time Reports -->
                            <li class="has-submenu">
                                <a href="#" class="has-arrow waves-effect">
                                    <i class="uil-google"></i>
                                    <span>Real Time Reports</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">

                                    <!-- Visitors Report -->
                                    <li class="has-submenu">
                                        <a href="#" class="has-arrow waves-effect">
                                            <i class="fas fa-users"></i>
                                            <span>Visitors</span>
                                        </a>
                                        <ul class="sub-menu" aria-expanded="false">
                                            <li>
                                                <a href="<?php echo e(route('totalVisitors')); ?>">
                                                    <i class="fas fa-chart-bar"></i> Full Analytics Report
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo e(route('sevenDaysTotalVisitors')); ?>">
                                                    <i class="fas fa-calendar-week"></i> 7 Days Visitors
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <!-- Most Visited Pages -->
                                    <li class="has-submenu">
                                        <a href="#" class="has-arrow waves-effect">
                                            <i class="fas fa-eye"></i>
                                            <span>Pages</span>
                                        </a>
                                        <ul class="sub-menu" aria-expanded="false">
                                            <li>
                                                <a href="<?php echo e(route('visitedPages')); ?>">
                                                    <i class="fas fa-calendar-alt"></i> Last Month
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo e(route('mostVisitedPages')); ?>">
                                                    <i class="fas fa-calendar-week"></i> 7 Days
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <!-- Location Insights -->
                                    <li class="has-submenu">
                                        <a href="#" class="has-arrow waves-effect">
                                            <i class="fas fa-map-marked-alt"></i>
                                            <span>Location Insights</span>
                                        </a>
                                        <ul class="sub-menu" aria-expanded="false">
                                            <li>
                                                <a href="<?php echo e(route('topCountries')); ?>">
                                                    <i class="fas fa-globe-americas"></i> Top Countries
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo e(route('topUsStates')); ?>">
                                                    <i class="fas fa-flag-usa"></i> Top U.S. States
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <!-- Flat Item -->
                                    <li>
                                        <a href="<?php echo e(route('topReferrers')); ?>">
                                            <i class="fas fa-share-square"></i> Top Referrers
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        </ul>
                    </li>

                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('access-admin-or-developer')): ?>
                    <li class="menu-title"><i class="uil-dashboard"></i> Admin</li>

                    <li>
                        <a href="#" class="has-arrow waves-effect" onclick="return false;">
                            <i class="uil-chart-line"></i>
                            <span>Management</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">

                            <li>
                                <a href="#" class="has-arrow waves-effect" onclick="return false;">
                                    <i class="far fa-save"></i>
                                    <span>System</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li>
                                        <a href="<?php echo e(url('program')); ?>"> <i class="far fa-star"></i>devpromaster Programs</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo e(url('password-manager')); ?>"><i
                                                class="uil-keyhole-square"></i>Passwords</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo e(url('user')); ?>"><i class="uil-chat-bubble-user"></i>Users</a>
                                    </li>

                                    <li>
                                        <a href="<?php echo e(url('history')); ?>">
                                            <i class="uil uil-history"></i> Our History
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo e(url('partner')); ?>">
                                            <i class="uil uil-layer-group"></i> Our Partners
                                        </a>
                                    </li>

                                    <li>
                                        <a href="<?php echo e(url('grant')); ?>"><i class="uil-dollar-sign"></i>Grants</a>
                                    </li>
                                    <li>
                                        <a href="#" class="has-arrow waves-effect" onclick="return false;">
                                            <i class="dripicons-archive"></i>
                                            <span>Docs</span>
                                        </a>
                                        <ul class="sub-menu" aria-expanded="false">
                                            <li>
                                                <a href="<?php echo e(url('docs/index.html')); ?>"><i
                                                        class="dripicons-document"></i>Admin Tech
                                                    Docs</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo e(url('https://devpromaster.org/docs/index.html')); ?>"><i
                                                        class="dripicons-document"></i>Website Tech Docs</a>
                                            </li>

                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="has-arrow waves-effect" onclick="return false;">
                                    <i class="uil-user-circle"></i>
                                    <span>Human Resources</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li>
                                        <a href="<?php echo e(url('human-resource')); ?>" aria-expanded="false">
                                            <i class="dripicons-user-id"></i>Staff Members</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo e(url('board-member')); ?>" aria-expanded="false">
                                            <i class="mdi mdi-account-tie-outline font-size-22"></i>Board Members</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo e(url('payroll')); ?>"><i class="uil-constructor"></i>Payroll</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo e(url('benefit')); ?>"><i class="uil-money-bill"></i>Employee Benefit</a>
                                    </li>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <li>
                                            <a href="#" class="has-arrow waves-effect">
                                                <i class="uil uil-monitor-heart-rate"></i>
                                                <span>Reports</span>
                                            </a>
                                            <ul class="sub-menu" aria-expanded="false">
                                                <li>
                                                    <a href="<?php echo e(url('timeWorkReportList')); ?>"><i
                                                            class="uil-clock-nine"></i>TimeWorkReport</a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo e(url('timeWorkQuarterlyReportList')); ?>"><i
                                                            class="fab fa-page4"></i>
                                                        Quarterly Report</a>
                                                </li>
                                            </ul>
                                        </li>

                                    </ul>
                                </ul>
                            </li>



                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['access-admin', 'access-developer', 'access-jcgrc', 'access-certification', 'access-developer', 'access-service'])): ?>
                <li class="menu-title"> <i class="uil-puzzle-piece"></i> Services</li>
                <li>
                    <a href="#" class="has-arrow waves-effect" onclick="return false;"><i
                            class="far fa-star"></i>devpromaster
                        Programs</a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="#" class="has-arrow waves-effect" onclick="return false;">
                                <i class="dripicons-browser"></i>
                                <span>My Website Page</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li>
                                    <a href="<?php echo e(route('simple-page.index')); ?>"><i class="dripicons-browser"></i>Simple
                                        Page</a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('testimonial.index')); ?>"><i
                                            class="uil-feedback"></i>Testimonial</a>
                                </li>

                            </ul>
                        </li>
                        <li>
                            <a class="has-arrow waves-effect">
                                <i class="uil-medal"></i>
                                <span>Capacity Building</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">

                                <!-- Year 2025 -->
                                <li>
                                    <a class="has-arrow waves-effect"><i class="uil-calendar-alt"></i>2025</a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <li><a href="<?php echo e(url('processing/2025')); ?>"><i
                                                    class="uil-pause"></i>Processing</a>
                                        </li>
                                        <li><a href="<?php echo e(url('applications/2025')); ?>"><i
                                                    class="fas fa-user-tie"></i>Manager</a></li>
                                        <li><a href="<?php echo e(url('advisor/2025')); ?>"><i
                                                    class="uil-comments-alt"></i>Advisor</a>
                                        </li>
                                        <li><a href="<?php echo e(url('pre-checked/2025')); ?>"><i
                                                    class="fas fa-flag-checkered"></i>Concluded</a></li>
                                    </ul>
                                </li>

                                <!-- Year 2026 -->
                                <li>
                                    <a class="has-arrow waves-effect"><i class="uil-calendar-alt"></i>2026</a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <li><a href="<?php echo e(url('processing/2026')); ?>"><i
                                                    class="uil-pause"></i>Processing</a>
                                        </li>
                                        <li><a href="<?php echo e(url('applications/2026')); ?>"><i
                                                    class="fas fa-user-tie"></i>Manager</a></li>
                                        <li><a href="<?php echo e(url('advisor/2026')); ?>"><i
                                                    class="uil-comments-alt"></i>Advisor</a>
                                        </li>
                                        <li><a href="<?php echo e(url('pre-checked/2026')); ?>"><i
                                                    class="fas fa-flag-checkered"></i>Concluded</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="<?php echo e(url('capacity-building-user')); ?>"><i class="uil-chat-bubble-user"></i>CP
                                        Users</a>
                                </li>
                                <li>
                                    <a href="<?php echo e(url('faq')); ?>"><i class="dripicons-information"></i>FAQ</a>
                                </li>
                            </ul>

                        </li>
                        <li>
                            <a class="has-arrow waves-effect" href="#">
                                <i class="uil-podium"></i>
                                <span>Compelling</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li>
                                    <a href="<?php echo e(route('course.index')); ?>"><i class="uil-book-alt"></i>Courses</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a class="has-arrow waves-effect">
                                <i class="fas fa-donate"></i>
                                <span>Fundraising</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li>
                                    <a href="#" class="has-arrow waves-effect">
                                        <i class="uil uil-credit-card"></i> 
                                        <span>Payments</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <li>
                                            <a href="<?php echo e(url('devpromaster-report-donations')); ?>">
                                                <i class="uil uil-credit-card"></i>devpromaster Funds
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(url('center-report-donations')); ?>">
                                                <i class="uil uil-credit-card"></i>González Center
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('campaign.index')); ?>">
                                        <i class="fas fa-bullhorn"></i>Campaigns
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href=" #" class="has-arrow waves-effect">
                                <i class="uil-fire"></i>
                                <span>JC Center</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li>
                                    <a href="#" class="has-arrow waves-effect">
                                        <i class="dripicons-archive"></i>
                                        <span>Collection</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <li>
                                            <a href="<?php echo e(url('digitalCollection')); ?>">
                                                <i class="fas fa-wrench"></i>All Files
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(url('digitalCollection/to-scan')); ?>">
                                                <i class="uil-copy"></i>To Scan
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(url('digitalCollection/create-watermark-digitalized')); ?>">
                                                <i class="far fa-file-word"></i>To Format
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(url('digitalCollection/digitalized')); ?>">
                                                <i class="uil uil-edit-alt"></i>To Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(url('digitalCollection/refined')); ?>">
                                                <i class="uil uil-check"></i>Edited
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(url('digitalCollection/proofed')); ?>">
                                                <i class="uil fas fa-signature"></i>Proofed
                                            </a>
                                        </li>

                                        <li>
                                            <a href="<?php echo e(url('copyright')); ?>">
                                                <i class="uil-copyright"></i>Copyrights
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(url('series')); ?>">
                                                <i class="bx bx-collection"></i>Collections
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(url('book')); ?>">
                                                <i class="uil-books"></i>Inventory
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('resourceCenterPayments')); ?>">
                                        <i class="uil uil-credit-card"></i>Payments
                                    </a>
                                </li>

                                <li>
                                    <a href="<?php echo e(url('archiveManager')); ?>">
                                        <i class="uil-suitcase"></i>
                                        <span>Dr. Justo's Maletín</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="has-arrow waves-effect">
                                        <i class="uil uil-user"></i>
                                        <span>Friends</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <li>
                                            <a href="<?php echo e(url('friend')); ?>">
                                                <i class="uil-users-alt"></i>All
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(url('active-friends')); ?>">
                                                <i class="uil-user-check text-success"></i>Active Year
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(url('to-expire-friends')); ?>" class="text-warning">
                                                <i class="uil-user-exclamation text-warning"></i>To Expire Year
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(url('inactive-friends')); ?>">
                                                <i class="uil-user-times text-danger"></i>Expired Year
                                            </a>
                                        </li>
                                    </ul>

                                </li>
                            </ul>

                        </li>
                        <li>
                            <a href="#" class="has-arrow waves-effect">
                                <i class="uil-university"></i>
                                <span>Pitt's Library</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li>
                                    <a href="<?php echo e(url('institution')); ?>"><i class="uil-university"></i>Bible's
                                        Institutes</a>
                                    <a href="<?php echo e(url('affiliate')); ?>"><i class="dripicons-graduation"></i>Students</a>
                                    <a href="<?php echo e(url('download-csv')); ?>"><i class="uil-file-download"></i>Download
                                        CSV</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?php echo e(url('youngLideres')); ?>">
                                <i class="uil-thumbs-up"></i>
                                <span>Young Líderes</span>
                            </a>
                        </li>


                    </ul>

                </li>
                <li>
                    <a href="#" class="has-arrow waves-effect" onclick="return false;">
                        <i class="uil-schedule"></i>
                        <span>devpromaster Events</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="<?php echo e(route('event.index')); ?>"><i class="far fa-calendar"></i>Events</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('speaker.index')); ?>"><i class="uil-megaphone"></i>Speakers</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('event-menu.index')); ?>"><i class="uil-restaurant"></i>Event Menu</a>
                        </li>
                        <li>
                            <a href="#" class="has-arrow waves-effect">
                                <i class="dripicons-jewel"></i>
                                <span>Sponsors</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li>
                                    <a href="<?php echo e(route('sponsor.index')); ?>">
                                        <i class="dripicons-trophy"></i> Sponsors
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('sponsor-type.index')); ?>">
                                        <i class="fas fa-tags"></i> Sponsor Types
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>

            </ul>

            </li>


            </ul>
            </li>


            <?php endif; ?>


            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('access-bible-institute')): ?>
                <li>
                    <a href="#" class="has-arrow waves-effect">
                        <i class="uil-university"></i>
                        <span>Pitt's Library</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="<?php echo e(url('affiliate')); ?>"><?php echo app('translator')->get('translation.Affiliates'); ?></a>
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