<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('/company/dashboard') }}"> <img alt="image"
                    src="{{ asset('public/admin/assets/images/mansol-01.png') }}" class="header-logo" style="width: 50%" />
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown {{ request()->is('company/dashboard') ? 'active' : '' }}">
                <a href="{{ url('/company/dashboard') }}" class="nav-link"><span><i
                            data-feather="home"></i>Dashboard</span></a>
            </li>
            {{-- Demands --}}
            <li class="dropdown {{ request()->is('company/company-projects*') || request()->is('company/project-demands*') || request()->is('company/demand-nominees*') ? 'active' : '' }}">
                <a href="{{ route('companyProject.index') }}" class="nav-link px-2">
                    <span><i class="fas fa-tasks"></i> Projects</span>
                </a>
            </li>
            {{-- Notifications --}}
            <li class="dropdown {{ request()->is('company/notification*') ? 'active' : '' }}">
                <a href="{{ route('notificationCompany.index') }}" class="nav-link">
                    <span><i data-feather="bell"></i>Notifcations</span>
                    <div id="orderCounter"
                        class="badge rounded-circle {{ request()->is('human-resouce/notification*') ? 'bg-white text-danger' : 'bg-danger text-white' }}">
                        1
                    </div>
                </a>
            </li>
            {{-- <li class="dropdown {{ request()->is('admin/company*') ? 'active' : '' }}">
                <a href="{{ route('company.index') }}" class="nav-link"><i data-feather="users"></i><span>Company</span></a>
            </li> --}}
            {{-- <li class="dropdown {{ request()->is('admin/officer*') ? 'active' : '' }}">
                <a href="{{ route('officer.index') }}" class="nav-link"><i data-feather="users"></i><span>Officer</span></a>
            </li> --}}
            {{-- <li class="dropdown {{ request()->is('admin/subadmin*') ? 'active' : '' }}">
                <a href="{{ route('subadmin.index') }}" class="nav-link"><span><i data-feather="user"></i>Sub Admins</span></a>
            </li> --}}
            {{-- <li class="dropdown {{ request()->is('company/about*') ? 'active' : '' }}">
                <a href="{{ route('about.index') }}" class="nav-link"><span><i data-feather="info"></i>About
                        Us</span></a>
            </li>
            <li class="dropdown {{ request()->is('admin/policy*') ? 'active' : '' }}">
                <a href="{{ route('policy.index') }}" class="nav-link"><span><i data-feather="shield"></i>Privacy
                        Policy</span></a>
            </li>
            <li class="dropdown {{ request()->is('admin/terms*') ? 'active' : '' }}">
               <a href="{{ route('terms.index') }}" class="nav-link">
                <span>  <i data-feather="file-text"></i> <!-- Icon for Terms & Conditions -->
                        Term & Condition</span>
                </a>
            </li>
            <li class="dropdown {{ request()->is('admin/faq*') ? 'active' : '' }}">
                <a href="{{ route('faq.index') }}" class="nav-link">
                    <span><i data-feather="help-circle"></i> <!-- Icon for FAQ's -->
                        FAQ's</span>
                </a>
            </li> --}}
        </ul>
    </aside>
</div>
