<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="{{ url('index') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('/assets/admin/images/logos/small.png') }}" alt="" height="80">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('/assets/admin/images/logos/small.png') }}" alt="" height="80">
            </span>
        </a>

        <a href="{{ url('index') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('/assets/admin/images/logos/small.png') }}" alt="" height="80">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('/assets/admin/images/logo-light.png') }}" alt="" height="80">
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
                @can('access-admin')
                    <li>
                        <a href="#" class="has-arrow waves-effect" onclick="return false;">
                            <i class="uil-setting"></i>
                            <span>Administration</span>
                        </a>

                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('users.index') }}"><i class="uil-chat-bubble-user"></i> Users</a></li>
                            <li><a href="{{ route('roles.index') }}"><i class="uil-users-alt"></i> Roles</a></li>
                            <li><a href="{{ route('audits.index') }}"><i class="uil-history"></i> Audit Trail</a></li>
                            <li><a href="{{ url('system-logs') }}"><i class="uil uil-bug"></i> System Logs</a></li>
                        </ul>
                    </li>
                @endcan
                @can('access-admin')
                    <li>
                        <a href="#" class="has-arrow waves-effect" onclick="return false;">
                            <i class="uil uil-graduation-cap"></i>
                            <span>LMS</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li class="menu-title">Content</li>
                            <li>
                                <a href="{{ route('course.index') }}">
                                    <i class="uil uil-award"></i> Courses
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('access-website-admin')
                    <li>
                        <a href="#" class="has-arrow waves-effect" onclick="return false;">
                            <i class="dripicons-browser"></i>
                            <span>Website</span>
                        </a>

                        <ul class="sub-menu" aria-expanded="false">
                            <li class="menu-title">Content</li>

                            <li><a href="{{ route('banners.index') }}"><i class="fas fa-image"></i> Banners</a></li>
                            <li><a href="{{ route('blogs.index') }}"><i class="uil-blogger-alt"></i> Blog</a></li>
                            <li><a href="{{ route('events.index') }}"><i class="uil uil-ticket"></i> Events</a></li>
                            <li><a href="{{ route('pages.index') }}"><i class="fas fa-file-alt"></i> Pages</a></li>
                            <li><a href="{{ route('partners.index') }}"><i class="fas fa-handshake"></i> Partners</a></li>
                            <li><a href="{{ route('positions.index') }}"><i class="uil uil-briefcase"></i> Open
                                    Positions</a></li>
                            <li><a href="{{ route('resources.index') }}"><i class="fas fa-folder-open"></i> Resources</a>
                            </li>
                            <li><a href="{{ route('teams.index') }}"><i class="fas fa-users"></i> Team</a></li>
                            <li><a href="{{ route('testimonials.index') }}"><i class="uil-feedback"></i> Testimonials</a>
                            </li>

                            <li class="menu-title">Configuration</li>

                            <li><a href="{{ route('menu-items.index') }}"><i class="fas fa-bars"></i> Menus</a></li>
                            <li><a href="{{ route('settings.index') }}"><i class="fas fa-cog"></i> Site Settings</a></li>
                            <li><a href="{{ route('social-links.index') }}"><i class="fas fa-share-alt"></i> Social
                                    Media</a></li>
                        </ul>
                    </li>
                @endcan

                @can('access-developer')
                    <li>
                        <a href="#" class="has-arrow waves-effect" onclick="return false;">
                            <i class="fas fa-tools"></i>
                            <span>Developer</span>
                        </a>

                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('developer-settings.index') }}">
                                    <i class="fas fa-exclamation-triangle text-danger"></i> Developer Settings
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan


            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->