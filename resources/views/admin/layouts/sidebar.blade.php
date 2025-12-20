<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="{{ url('index') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('/assets/admin/images/logos/small.png') }}" alt="" height="40">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('/assets/admin/images/logos/small.png') }}" alt="" height="40">
            </span>
        </a>

        <a href="{{ url('index') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('/assets/admin/images/logos/small.png') }}" alt="" height="40">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('/assets/admin/images/logo-light.png') }}" alt="" height="40">
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
                <li>
                    <a href="#" class="has-arrow waves-effect" onclick="return false;">
                        <i class="dripicons-browser"></i>
                        <span>Website</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('banners.index') }}">
                                <i class="fas fa-image"></i>Banners
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('blogs.index') }}">
                                <i class="uil-blogger-alt"></i>Blog
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('events.index') }}">
                                <i class="uil uil-ticket"></i>Events
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <i class="uil uil-layer-group"></i> Our Partners
                            </a>
                        </li>
                        <li>
                            <a href=""> <i class="uil uil-briefcase"></i> Open Positions
                            </a>
                        </li>
                        <li>
                            <a href=""><i class="uil-feedback"></i>Testimonial</a>
                        </li>
                    </ul>
                </li>

                </li>
                @can('access-admin')
                    <li>
                        <a href="#" class="has-arrow waves-effect" onclick="return false;">
                            <i class="uil-setting"></i>
                            <span>Administration</span>
                        </a>

                        <ul class="sub-menu" aria-expanded="false">

                            {{-- Users --}}
                            <li>
                                <a href="{{ route('users.index') }}">
                                    <i class="uil-chat-bubble-user"></i> Users
                                </a>
                            </li>
                            {{-- Roles --}}
                            <li>
                                <a href="{{ route('roles.index') }}">
                                    <i class="uil-users-alt"></i> Roles
                                </a>
                            </li>

                            {{-- Audit Trail --}}
                            <li>
                                <a href="{{ route('audits.index') }}">
                                    <i class="uil-history"></i> Audit Trail
                                </a>
                            </li>
                            {{-- Error Logs --}}
                            <li>
                                <a href="{{ url('system-logs') }}">
                                    <i class="uil uil-bug"></i> System Logs
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