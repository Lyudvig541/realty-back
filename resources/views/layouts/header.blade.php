<style>
    .c-avatar-img{
        border-radius: 50%;
        height: 100% !important;
    }
</style>
<header class="c-header c-header-light c-header-fixed c-header-with-subheader">
    <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
        <i class="c-icon c-icon-2xl cil-hamburger-menu"></i>
    </button>
    <a class="c-header-brand d-lg-none" href="#"></a>
    <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
        <i class="c-icon c-icon-2xl cil-hamburger-menu"></i>
    </button>

    <ul class="c-header-nav ml-auto mr-4">
        <li class="c-header-nav-item d-md-down-none mx-2">
            <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="c-icon mr-2 cif-{{app()->getLocale() == 'en' ? 'us' : app()->getLocale()}}"></i>
                {{ app()->getLocale() ? strtoupper(app()->getLocale()) : 'am'}}
            </a>
            <div class="dropdown-menu dropdown-menu-right pt-0">
                <a class="dropdown-item" href="/locale/am">
                    <i class="c-icon mr-2 cif-am"></i>
                    AM
                </a>
                <a class="dropdown-item" href="/locale/en">
                    <i class="c-icon mr-2 cif-us"></i>
                    EN
                </a>
                <a class="dropdown-item" href="/locale/ru">
                    <i class="c-icon mr-2 cif-ru"></i>
                    RU
                </a>
            </div>
        </li>
        <li class="c-header-nav-item dropdown">
            <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <div class="c-avatar">
                    <img class="c-avatar-img" src="{{auth()->user()->avatar ? asset('/storage/uploads/users/'.auth()->user()->avatar) : '/assets/img/avatar.png'}}" alt="...">
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right pt-0">
                <a class="dropdown-item" href="{{route('change_password')}}">
                    <i class="c-icon mr-2 fa fa-key"></i>
                    {{__('translations.change_password')}}
                </a>
                <a class="dropdown-item" href="{{route('profile')}}">
                    <i class="c-icon mr-2 cil-user"></i>
                    {{__('translations.profile')}}
                </a>
                <a class="dropdown-item" href="{{ route('logout')}}"
                   onclick="event.preventDefault()
                    document.getElementById('logout-form').submit();">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    <i class="c-icon mr-2 cil-account-logout"></i>
                    {{__('translations.logout')}}
                </a>
            </div>
        </li>
    </ul>
</header>

