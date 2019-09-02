<li class="nav-item dropdown">
    <a class="nav-link navbar-avatar" data-toggle="dropdown" href="#" aria-expanded="false"
       data-animation="scale-up" role="button">
              <span class="avatar avatar-online">
                      <img src="{{Modules\Core\Entities\User::avatar(Auth::user()->id)}}" />
              </span>
    </a>
    <div class="dropdown-menu" role="menu">
        {{ loadExtendableView("top_user_menu") }}
    </div>
</li>
