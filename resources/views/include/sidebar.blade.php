<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
            </span>
            <img src="{{ asset('/public/Vector.png') }}" alt="" width="200">
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>


    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
            <li class="menu-item {{ Request::is('/') || Request::is('dashboard')  ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Analytics"> Dashboard</div>
                </a>
            </li>
            @if($user->user_type == "Admin")
            <li
                class="menu-item {{ Request::is('businesses') || Request::is('edit-business') ? 'active' : '' }}">
                <a href="{{ route('business.index') }}" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bxs-business"></i>
                    <div data-i18n="Layouts">Businesses</div>
                </a>
            </li>


            <li class="menu-item {{ Request::is('users') || Request::is('edit-user') ? 'active' : '' }}">
                <a href="{{ route('user.index') }}" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bi bi-person"></i>
                    <div data-i18n="Analytics"> Users</div>
                </a>
            </li>
            <li
                class="menu-item {{ Request::is('dashboard-drivers') || Request::is('dashboard-driver-show') || Request::is('driver-edit') ? 'active' : '' }}">
                <a href="{{ route('dashboard_drivers.index') }}" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bi bi-person"></i>
                    <div data-i18n="Layouts">Drivers</div>
                </a>
            </li>
            @else
            <li
                class="menu-item {{ Request::is('orders') || Request::is('order') ? 'active' : '' }}">
                <a href="{{ route('order.index') }}" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-cart"></i>
                    <div data-i18n="Layouts">Orders</div>
                </a>
            </li>
            @endif
    </ul>
</aside>
<!-- / Menu -->
