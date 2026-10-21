<!-- leftbar-tab-menu -->
<div class="leftbar-tab-menu">
    <div class="main-menu-inner">
        <!-- LOGO -->
        <div class="topbar-left">
            <a href="{{ url('/admin/dashboard') }}" class="logo">
                <img src="{{ asset('administrator/assets/images/logo-text.png') }}" alt="logo-small" style="max-height: 150px">
            </a>
        </div>
        <!--end logo-->
        <div class="menu-body slimscroll">
            <div id="MetricaDashboard" class="main-icon-menu-pane active">
                <div class="title-box">
                    <h6 class="menu-title">{{ __('site.menu.dashboard') }}</h6>
                </div>
                <ul class="nav">
                    <li class="nav-item"><a class="nav-link" href="{{ route('departments.index') }}">{{ __('site.menu.department') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('pages.index') }}">{{ __('site.menu.page') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admins.index') }}">{{ __('site.menu.admin') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('settings.index') }}">{{ __('site.menu.setting') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('blog-categories.index') }}">{{ __('site.menu.blog_category') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('blog-posts.index') }}">{{ __('site.menu.blog_post') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('widgets.index') }}">{{ __('site.menu.widget') }}</a></li>
                </ul>
            </div><!-- end Dashboards -->
        </div><!--end menu-body-->
    </div><!-- end main-menu-inner-->
</div>
