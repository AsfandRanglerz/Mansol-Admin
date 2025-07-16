<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('/human-resource/dashboard') }}"> <img alt="image"
                    src="{{ asset('public/admin/assets/images/mansol-01.png') }}" class="header-logo" style="width: 50%" />
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown {{ request()->is('human-resource/dashboard') ? 'active' : '' }}">
                <a href="{{ url('/human-resource/dashboard') }}" class="nav-link"><span><i
                            data-feather="home"></i>Dashboard</span></a>
            </li>
            {{-- My Profile --}}
            <li class="dropdown {{ request()->is('human-resource/my-profile*') ? 'active' : '' }}">
                <a href="{{ route('myprofile.index') }}" class="nav-link px-2">
                    <span><i class="fas fa-user"></i> My Profile</span>
                </a>
            </li>
            {{-- Notifications --}}
            <li class="dropdown {{ request()->is('human-resource/notification*') ? 'active' : '' }}">
                <a href="{{ route('notificationHumanResouce.index') }}" class="nav-link">
                    <span><i data-feather="bell"></i> Notifications</span>

                    @php
                        use App\Models\NotificationTarget;

                        $hr = auth('humanresource')->user();
                        $notificationCount = 0;

                        if ($hr) {
                            $notificationCount = NotificationTarget::where(
                                'targetable_type',
                                \App\Models\HumanResource::class,
                            )
                                ->where('targetable_id', $hr->id)
                                ->where(function ($q) {
                                    $q->where('is_read', 0)->orWhereNull('is_read');
                                })
                                ->count();
                        }
                    @endphp

                    @if ($notificationCount > 0)
                        <div id="orderCounter"
                            class="badge rounded-circle {{ request()->is('human-resource/notification*') ? 'bg-white text-danger' : 'bg-danger text-white' }}"
                            style="margin-left: 8px; font-size: 12px; padding: 4px 7px;">
                            {{ $notificationCount }}
                        </div>
                    @endif
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
