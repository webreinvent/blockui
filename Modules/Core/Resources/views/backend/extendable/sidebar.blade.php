<li class="site-menu-item">
    <a href="{{route("core.backend.dashboard")}}">
        <i class="site-menu-icon wb-dashboard" aria-hidden="true"></i>
        <span class="site-menu-title">Dashboard</span>
        {{--<div class="site-menu-badge">
            <span class="tag label-pill tag-success">3</span>
        </div>--}}
    </a>
</li>
@if(Auth::user()->hasPermission("core", "backend-admin-menu"))
<li class="site-menu-item has-sub">
    <a href="javascript:void(0)">
        <i class="site-menu-icon wb-briefcase" aria-hidden="true"></i>
        <span class="site-menu-title">Core</span>
        <span class="site-menu-arrow"></span>
    </a>
    <ul class="site-menu-sub">
        @if(Auth::user()->hasPermission("core", "backend-admin-user-read"))
        <li class="site-menu-item">
            <a class="animsition-link" href="{{route("core.backend.users")}}">
                <span class="site-menu-title">Users</span>
            </a>
        </li>
        @endif
        @if(Auth::user()->hasPermission("core", "backend-admin-role-read"))
        <li class="site-menu-item">
            <a class="animsition-link" href="{{route("core.backend.roles")}}">
                <span class="site-menu-title">Roles</span>
            </a>
        </li>
        @endif
        @if(Auth::user()->hasPermission("core", "backend-admin-permission-read"))
        <li class="site-menu-item">
            <a class="animsition-link" href="{{route("core.backend.permissions")}}">
                <span class="site-menu-title">Permissions</span>
            </a>
        </li>
            @endif
    </ul>
</li>
@endif
