<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand d-lg-down-none p-2">
        <a href="/">
            <img src="{{asset('/assets/img/logo.svg')}}" alt="image">
        </a>
    </div>
    <ul class="c-sidebar-nav">
        @if (auth()->user()->hasRole('admin'))
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link {{ request()->segment(2) === 'dashboard' ? 'c-active' : null }}" href="{{route('dashboard')}}">
                    <i class="c-sidebar-nav-icon cil-gauge"></i>
                    {{__('translations.dashboard')}}
                </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link {{ request()->segment(2) === 'users' ? 'c-active' : null }}" href="{{route('users')}}">
                    <i class="c-sidebar-nav-icon cil-group"></i>
                    {{__('translations.users')}}
                </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link {{ request()->segment(2) === 'categories' ? 'c-active' : null }}" href="{{route('categories')}}">
                    <i class="c-sidebar-nav-icon cil-playlist-add"></i>
                    {{ __('translations.categories') }}
                </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link {{ request()->segment(2) === 'types' ? 'c-active' : null }}" href="{{route('types')}}">
                    <i class="c-sidebar-nav-icon cil-list-high-priority"></i>
                    {{ __('translations.types') }}
                </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link {{ request()->segment(2) === 'brokers' ? 'c-active' : null }}" href="{{route('brokers')}}">
                    <i class="c-sidebar-nav-icon fa fa-users"></i>
                    {{ __('translations.brokers') }}
                </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link {{ request()->segment(2) === 'brokers_company' ? 'c-active' : null }}" href="{{route('super_brokers')}}">
                    <i class="c-sidebar-nav-icon fa fa-users"></i>
                    {{ __('translations.brokers_company') }}
                </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link {{ request()->segment(2) === 'agents-requests' ? 'c-active' : null }}" href="{{route('agents_requests')}}">
                    <i class="c-sidebar-nav-icon fa fa-user-plus"></i>
                    Agents/Brokers Requests
                </a>
            </li>
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle">
                    <i class="c-sidebar-nav-icon cib-hackhands"></i>
                    {{ __('translations.announcements') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link {{ request()->segment(2) === 'announcements' ? 'c-active' : null }}" href="{{route('announcements')}}">
                            <span class="c-sidebar-nav-icon"></span>
                            {{ __('translations.announcements') }}
                        </a>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link {{ request()->segment(2) === 'verify_announcements' ? 'c-active' : null }}" href="{{route('verify_announcements')}}">
                            <span class="c-sidebar-nav-icon"></span>
                            {{ __('translations.verify_announcements') }}
                        </a>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link {{ request()->segment(2) === 'archive_announcements' ? 'c-active' : null }}" href="{{route('archive_announcements')}}">
                            <span class="c-sidebar-nav-icon"></span>
                            {{ __('translations.archive_announcements') }}
                        </a>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link {{ request()->segment(2) === 'additional_infos' ? 'c-active' : null }}" href="{{route('additional_infos')}}">
                            <span class="c-sidebar-nav-icon"></span>
                            {{ __('translations.additional_info') }}
                        </a>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link {{ request()->segment(2) === 'facilities' ? 'c-active' : null }}" href="{{route('facilities')}}">
                            <span class="c-sidebar-nav-icon"></span>
                            {{ __('translations.facilities') }}
                        </a>
                    </li>
                </ul>
            </li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link {{ request()->segment(2) === 'constructors' ? 'c-active' : null }}" href="{{route('constructors')}}">
                    <i class="c-sidebar-nav-icon cil-building"></i>
                    {{ __('translations.from_construction') }}
                </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link {{ request()->segment(2) === 'constructor_agencies' ? 'c-active' : null }}" href="{{route('constructor_agencies')}}">
                    <i class="c-sidebar-nav-icon cil-building"></i>
                    {{ __('translations.construction_agencies') }}
                </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link {{ request()->segment(2) === 'partners' ? 'c-active' : null }}" href="{{route('partners')}}">
                    <i class="c-sidebar-nav-icon fa fa-handshake"></i>
                    {{ __('translations.partners') }}
                </a>
            </li>

            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link {{ request()->segment(2) === 'agencies' ? 'c-active' : null }}" href="{{route('agencies')}}">
                    <i class="c-sidebar-nav-icon cil-briefcase"></i>
                    {{ __('translations.agencies') }}
                </a>
            </li>

            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link {{ request()->segment(2) === 'comments' ? 'c-active' : null }}" href="{{route('comments')}}">
                    <i class="c-sidebar-nav-icon fa fa-comment"></i>
                    {{ __('translations.comments') }}
                </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link {{ request()->segment(2) === 'text' ? 'c-active' : null }}" href="{{route('texts')}}">
                    <i class="c-sidebar-nav-icon fa fa-align-left"></i>
                    {{ __('translations.texts') }}
                </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link {{ request()->segment(2) === 'credit_companies' ? 'c-active' : null }}" href="{{route('credit_companies')}}">
                    <i class="c-sidebar-nav-icon fa fa-compass"></i>
                    {{ __('translations.credit_companies') }}
                </a>
            </li>

            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link {{ request()->segment(2) === 'banners' ? 'c-active' : null }}" href="{{route('banners')}}">
                    <i class="c-sidebar-nav-icon cib-slides"></i>
                    {{ __('translations.banners') }}
                </a>
            </li>

            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link {{ request()->segment(2) === 'bank_requests' ? 'c-active' : null }}" href="{{route('bank_requests')}}">
                    <i class="c-sidebar-nav-icon fa fa-university"></i>
                    {{ __('translations.bank_requests') }}
                </a>
            </li>

            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link {{ request()->segment(2) === 'pages' ? 'c-active' : null }}" href="{{route('pages')}}">
                    <i class="c-sidebar-nav-icon fa fa-table"></i>
                    {{ __('translations.pages') }}
                </a>
            </li>

            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="c-sidebar-nav-icon cil-settings"></i>
                    {{ __('translations.settings') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link {{ request()->segment(2) === 'countries' ? 'c-active' : null }}" href="{{route('countries')}}">
                            <span class="c-sidebar-nav-icon"></span>
                            {{ __('translations.country') }}

                        </a>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link {{ request()->segment(2) === 'states' ? 'c-active' : null }}" href="{{route('states')}}">
                            <span class="c-sidebar-nav-icon"></span>
                            {{ __('translations.state') }}
                        </a>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link {{ request()->segment(2) === 'cities' ? 'c-active' : null }}" href="{{route('cities')}}">
                            <span class="c-sidebar-nav-icon"></span>
                            {{ __('translations.city') }}
                        </a>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link {{ request()->segment(2) === 'currencies' ? 'c-active' : null }}" href="{{route('currencies')}}">
                            <i class="c-sidebar-nav-icon cil-money"></i>
                            {{ __('translations.currencies') }}
                        </a>
                    </li>
                </ul>
            </li>
        @endif
        @if (auth()->user()->hasRole('super_broker'))
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->segment(2) === 'dashboard' ? 'c-active' : null }}" href="{{route('dashboard')}}">
                        <i class="c-sidebar-nav-icon cil-gauge"></i>
                        {{__('translations.dashboard')}}
                    </a>
                </li>
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->segment(2) === 'brokers' ? 'c-active' : null }}" href="{{route('brokers')}}">
                        <i class="c-sidebar-nav-icon fa fa-users"></i>
                        {{ __('translations.brokers') }}
                    </a>
                </li>
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->segment(2) === 'brokers_announcements' ? 'c-active' : null }}" href="{{route('brokers_announcements')}}">
                        <i class="c-sidebar-nav-icon fa fa-users"></i>
                        {{ __('translations.brokers_announcements') }}
                    </a>
                </li>
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->segment(2) === 'messages' ? 'c-active' : null }}" href="{{route('messages')}}">
                        <i class="c-sidebar-nav-icon cil-gauge"></i>
                        {{__('translations.messages')}}
                    </a>
                </li>
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->segment(2) === 'announcements' ? 'c-active' : null }}" href="{{route('announcements')}}">
                        <i class="c-sidebar-nav-icon cib-hackhands"></i>
                        {{ __('translations.my_announcements') }}
                    </a>
                </li>
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->segment(3) === 'attached-announcements' ? 'c-active' : null }}" href="{{route('attached_announcements')}}">
                        <i class="c-sidebar-nav-icon cib-hackhands"></i>
                        {{ __('translations.attached_announcements') }}
                    </a>
                </li>
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->segment(3) === 'free-announcements' ? 'c-active' : null }}" href="{{route('free_announcements')}}">
                        <i class="c-sidebar-nav-icon cib-hackhands"></i>
                        {{ __('translations.free_announcements') }}
                    </a>
                </li>
        @endif
        @if (auth()->user()->hasRole('broker'))
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->segment(2) === 'dashboard' ? 'c-active' : null }}" href="{{route('dashboard')}}">
                        <i class="c-sidebar-nav-icon cil-gauge"></i>
                        {{__('translations.dashboard')}}
                    </a>
                </li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link {{ request()->segment(2) === 'messages' ? 'c-active' : null }}" href="{{route('messages')}}">
                    <i class="c-sidebar-nav-icon cil-gauge"></i>
                    {{__('translations.messages')}}
                </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link {{ request()->segment(2) === 'announcements' ? 'c-active' : null }}" href="{{route('announcements')}}">
                    <i class="c-sidebar-nav-icon cib-hackhands"></i>
                    {{ __('translations.my_announcements') }}
                </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link {{ request()->segment(3) === 'attached-announcements' ? 'c-active' : null }}" href="{{route('attached_announcements')}}">
                    <i class="c-sidebar-nav-icon cib-hackhands"></i>
                    {{ __('translations.attached_announcements') }}
                </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link {{ request()->segment(3) === 'free-announcements' ? 'c-active' : null }}" href="{{route('free_announcements')}}">
                    <i class="c-sidebar-nav-icon cib-hackhands"></i>
                    {{ __('translations.free_announcements') }}
                </a>
            </li>
        @endif
    </ul>

    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
</div>

<div class="c-wrapper c-fixed-components">
    <div class="c-body">
        @include('layouts.header')

        <main class="c-main">

            @yield('content')

        </main>
        @include('layouts.footer')
    </div>
</div>
