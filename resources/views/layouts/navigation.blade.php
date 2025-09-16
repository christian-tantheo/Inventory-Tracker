<ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-speedometer') }}"></use>
            </svg>
            {{ __('Dashboard') }}
        </a>
    </li>

    @if(auth()->user()->hasRole('Admin'))
        <li class="nav-item">
            <a class="nav-link {{ request()->is('users*') ? 'active' : ''}}" href="{{ route('users.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-user') }}"></use>
                </svg>
                {{ __('Users') }}
            </a>
        </li>
    @endif

    {{-- <li class="nav-item">
        <a class="nav-link {{ request()->is('roles*') ? 'active' : ''}}" href="{{ route('roles.index') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-group') }}"></use>
            </svg>
            {{ __('Roles') }}
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->is('permissions*') ? 'active' : ''}}" href="{{ route('permissions.index') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-room') }}"></use>
            </svg>
            {{ __('Permissions') }}
        </a>
    </li> --}}

    <li class="nav-item">
        <a class="nav-link {{ request()->is('assets*') ? 'active' : ''}}" href="{{ route('assets.index') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-cart') }}"></use>
            </svg>
            {{ __('Assets') }}
        </a>
    </li>

    <li class="nav-group" aria-expanded="false">
    <a class="nav-link nav-group-toggle" href="#">
        <svg class="nav-icon">
            <use xlink:href="{{ asset('icons/coreui.svg#cil-dollar') }}"></use>
        </svg>
        Finance
    </a>
    <ul class="nav-group-items">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('expenses.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-list') }}"></use>
                </svg>
                Expense Form
            </a>
        </li>
        @if(auth()->user()->hasRole('Admin'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('expenses.approval') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-check-circle') }}"></use>
                </svg>
                Expense Approval
            </a>
        </li>
        @endif
    </ul>
</li>

</ul>
