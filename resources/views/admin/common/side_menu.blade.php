<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('admin/dashboard') }}"> <img alt="image"
                    src="{{ asset('public/admin/assets/images/mansol-01.png') }}" class="header-logo" style="width: 50%" />
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <a href="{{ url('admin/dashboard') }}" class="nav-link"><span><i
                            data-feather="home"></i>Dashboard</span></a>
            </li>
            {{-- <li class="dropdown {{ request()->is('admin/company*') ? 'active' : '' }}">
                <a href="{{ route('company.index') }}" class="nav-link"><i data-feather="users"></i><span>Company</span></a>
            </li> --}}
            {{-- <li class="dropdown {{ request()->is('admin/officer*') ? 'active' : '' }}">
                <a href="{{ route('officer.index') }}" class="nav-link"><i data-feather="users"></i><span>Officer</span></a>
            </li> --}}
            {{-- Roles --}}
              @php
                $canViewRoles = Auth::guard('admin')->check() || 
                    (Auth::guard('subadmin')->check() && \App\Models\SubAdmin::hasSpecificPermission(Auth::guard('subadmin')->id(), 'Roles', 'view'));
            @endphp
            @if ($canViewRoles)
            <li class="dropdown {{ request()->is('admin/roles*') ? 'active' : '' }}">
                <a href="{{ route('roles.index') }}" class="nav-link">
                    <span><i data-feather="shield"></i>Roles</span>
                </a>
            </li>
            @endif
            
            {{-- SubAdmin --}}
            @php
                $canViewSubadmin = Auth::guard('admin')->check() || 
                    (Auth::guard('subadmin')->check() && \App\Models\SubAdmin::hasSpecificPermission(Auth::guard('subadmin')->id(), 'Sub Admins', 'view'));
            @endphp
            @if ($canViewSubadmin)
                <li class="dropdown {{ request()->is('admin/subadmin*') ? 'active' : '' }}">
                    <a href="{{ route('subadmin.index') }}" class="nav-link"><span><i data-feather="user"></i>Sub Admins</span></a>
                </li>
            @endif

            {{-- Main Craft --}}
            @php
                $canViewCrafts = Auth::guard('admin')->check() || 
                    (Auth::guard('subadmin')->check() && \App\Models\SubAdmin::hasSpecificPermission(Auth::guard('subadmin')->id(), 'Main Crafts', 'view'));
            @endphp
            @if ($canViewCrafts)
                <li class="dropdown {{ request()->is('admin/mainCraft*') || request()->is('admin/Craftsub*') ? 'active' : '' }}">
                    <a href="{{ route('maincraft.index') }}" class="nav-link"><span><i data-feather="scissors"></i> Main Crafts</span></a>
                </li>
            @endif

            {{-- Human Resource --}}
            @php
                $canViewHR = Auth::guard('admin')->check() || 
                    (Auth::guard('subadmin')->check() && \App\Models\SubAdmin::hasSpecificPermission(Auth::guard('subadmin')->id(), 'Human Resources', 'view'));
            @endphp
            @if ($canViewHR)
                <li class="dropdown {{ request()->is('admin/human-resource*') ? 'active' : '' }}">
                    <a href="{{ route('humanresource.index') }}" class="nav-link"><span><i data-feather="users"></i>Human Resources</span></a>
                </li>
            @endif

            {{-- Approved Applicants --}}
            {{-- @if (Auth::guard('admin')->check())
                <li class="dropdown {{ request()->is('admin/approved-applicant*') ? 'active' : '' }}">
                    <a href="{{ route('approved.applicants.index') }}" class="nav-link px-2">
                        <span><i class="fas fa-thumbs-up"></i> Approved Applicants</span>
                    </a>
                </li>
                
            @endif
           --}}

            {{-- Nominations --}}
            {{-- @php
                $canViewNominations = Auth::guard('admin')->check() || 
                    (Auth::guard('subadmin')->check() && \App\Models\SubAdmin::hasSpecificPermission(Auth::guard('subadmin')->id(), 'Assigned Resources', 'view'));
            @endphp
            @if ($canViewNominations)
                <li class="dropdown {{ request()->is('admin/nominations*') ? 'active' : '' }}">
                    <a href="{{ route('nominations.index') }}" class="nav-link px-2">
                        <span><i class="fas fa-award"></i> Assigned Resources</span>
                    </a>
                </li>
            @endif --}}

            {{-- Companies --}}
            @php
                $canViewCompanies = Auth::guard('admin')->check() || 
                    (Auth::guard('subadmin')->check() && \App\Models\SubAdmin::hasSpecificPermission(Auth::guard('subadmin')->id(), 'Companies', 'view'));
            @endphp
            @if ($canViewCompanies)
                <li class="dropdown {{ request()->is('admin/companies*') || request()->is('admin/demands*') || request()->is('admin/nominate*') ? 'active' : '' }}">
                    <a href="{{ route('companies.index') }}" class="nav-link">
                        <span><i data-feather="briefcase"></i>Companies</span>
                    </a>
                </li>
            @endif

             {{-- @php
                $canViewCompanies = Auth::guard('admin')->check() || 
                    (Auth::guard('subadmin')->check() && \App\Models\SubAdmin::hasSpecificPermission(Auth::guard('subadmin')->id(), 'Companies', 'view'));
            @endphp
            @if ($canViewCompanies)
                <li class="dropdown {{ request()->is('admin/companies*') || request()->is('admin/demands*') || request()->is('admin/nominate*') ? 'active' : '' }}">
                    <a href="{{ route('companies.index') }}" class="nav-link">
                        <span><i data-feather="briefcase"></i>Project Reports</span>
                    </a>
                </li>
            @endif --}}

            {{-- project reports --}}
            <li class="dropdown {{ request()->is('admin/project-reports*') ? 'active' : '' }}">
                <a href="{{ route('project-reports.index') }}" class="nav-link">
                    <span><i data-feather="bar-chart-2"></i>Project Reports</span>
                </a>
            </li>

            {{-- flight reports --}}
            <li class="dropdown {{ request()->is('admin/flight-reports*') ? 'active' : '' }}">
                <a href="{{ route('flight-reports.index') }}" class="nav-link">
                    <span><i data-feather="navigation"></i>Flight Reports</span>
                </a>
            </li>

            {{-- Reports --}}
            {{-- <li class="dropdown {{ request()->is('admin/reports*') ? 'active' : '' }}">
                <a href="{{ route('reports.index') }}" class="nav-link px-2">
                    <span><i class="fas fa-chart-line"></i> Reports</span>
                </a>
            </li> --}}

            {{-- Notifications --}}
             @php
                $canViewNotification = Auth::guard('admin')->check() || 
                    (Auth::guard('subadmin')->check() && \App\Models\SubAdmin::hasSpecificPermission(Auth::guard('subadmin')->id(), 'Notifications', 'view'));
            @endphp
            @if ($canViewNotification)
            <li class="dropdown {{ request()->is('admin/notification*') ? 'active' : '' }}">
                <a href="{{ route('notification.index') }}" class="nav-link">
                    <span><i data-feather="bell"></i>Notifcations
                    <div id="orderCounter"
                            class="badge {{ request()->is('admin/notification*') ? 'bg-white text-danger' : 'bg-danger text-white' }} rounded-circle ">
                        </div>
                    </span>
                </a>
            </li>
            @endif
            {{-- <li class="dropdown {{ request()->is('admin/about*') ? 'active' : '' }}">
                <a href="{{ route('about.index') }}" class="nav-link"><span><i data-feather="info"></i>About
                        Us</span></a>
            </li>
            <li class="dropdown {{ request()->is('admin/policy*') ? 'active' : '' }}">
                <a href="{{ route('policy.index') }}" class="nav-link"><span><i data-feather="shield"></i>Privacy
                        Policy</span></a>
            </li>
            <li class="dropdown {{ request()->is('admin/terms*') ? 'active' : '' }}">
                <a href="{{ route('terms.index') }}" class="nav-link">
                    <span> <i data-feather="file-text"></i> <!-- Icon for Terms & Conditions -->
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
