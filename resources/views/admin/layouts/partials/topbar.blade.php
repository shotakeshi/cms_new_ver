<div class="topbar">
    <nav class="navbar-custom">
        <ul class="list-unstyled topbar-nav float-right mb-0">
            <li class="hidden-sm">
                <a class="nav-link dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="javascript: void(0);" role="button"
                   aria-haspopup="false" aria-expanded="false">
                    @foreach($globalLanguages as $language)
                        @if($language->slug === app()->getLocale())
                            {{ $language->name }} <img src="{{ asset('flags/'.$language->slug.'.png') }}" class="ml-2" height="16" alt=""/>
                            <i class="mdi mdi-chevron-down"></i>
                        @endif
                    @endforeach
                </a>
                <div class="dropdown-menu dropdown-menu-right text-right">
                    @foreach($globalLanguages as $language)
                        <a class="dropdown-item" href="{{ route('change-language',$language->slug) }}"><span> {{ $language->name }} </span>
                            <img class="ml-2" height="14" src="{{ asset('flags/'.$language->slug.'.png') }}" alt="{{ $language->name }}">
                        </a>
                    @endforeach
                </div>
            </li>
            <li class="dropdown">
                <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                   aria-haspopup="false" aria-expanded="false">
                    <img src="{{ showImage(Auth::guard('admin')->user()->avatar) }}" alt="profile-user" class="rounded-circle" />
                    <span class="ml-1 nav-user-name hidden-sm">{{ Auth::guard('admin')->name }} <i class="mdi mdi-chevron-down"></i> </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('admin.profile') }}">
                        <i class="dripicons-user text-muted mr-2"></i> {{ __('site.admin.profile') }}
                    </a>
                    <a class="dropdown-item" href="{{ route('admin.change-password') }}">
                        <i class="dripicons-gear text-muted mr-2"></i> {{ __('site.button.change_password') }}
                    </a>
                    <a class="dropdown-item" href="{{ route('admin.logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="mdi mdi-power text-danger mr-2"></i> {{ __('site.button.logout') }}
                    </a>
                    <form id="logout-form" class="d-none" action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                    </form>
                </div>
            </li>
        </ul><!--end topbar-nav-->
        <ul class="list-unstyled topbar-nav mb-0">
            <li>
                <a href="#">
                    <span class="responsive-logo">
                        <img src="{{ asset('administrator/assets/images/logo-sm.png') }}" alt="logo-small" class="logo-sm align-self-center" height="40">
                    </span>
                </a>
            </li>
            <li>
                <button class="button-menu-mobile nav-link waves-effect waves-light">
                    <i data-feather="menu" class="align-self-center"></i>
                </button>
            </li>
        </ul>
    </nav>
    <!-- end navbar-->
</div>
<!-- Top Bar End -->