@php( $logout_url = View::getSection('logout_url') ?? config('adminlte.logout_url', 'logout') )
@php( $profile_url = View::getSection('profile_url') ?? config('adminlte.profile_url', 'logout') )
@php( $api_token_url = View::getSection('profile_url') ?? config('adminlte.profile_url', 'logout') )

@if (config('adminlte.usermenu_profile_url', false))
    @php( $profile_url = Auth::user()->adminlte_profile_url() )
    @php( $api_token_url = Auth::user()->adminlte_api_token_url() )
@endif

@if (config('adminlte.use_route_url', false))
    @php( $profile_url = $profile_url ? route($profile_url) : '' )
    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
        @php( $api_token_url = $api_token_url ? route($api_token_url) : '' )
    @endif
    @php( $logout_url = $logout_url ? route($logout_url) : '' )
@else
    @php( $profile_url = $profile_url ? url($profile_url) : '' )
    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
        @php( $api_token_url = $api_token_url ? url($api_token_url) : '' )
    @endif
    @php( $logout_url = $logout_url ? url($logout_url) : '' )
@endif

<li class="nav-item dropdown user-menu">

    {{-- User menu toggler --}}
    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
        @if(config('adminlte.usermenu_image'))
            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <img class="user-image img-circle elevation-2 img-fluid" src="{{ asset(Auth::user()->profile_photo_url) }}"
                alt="{{ Auth::user()->profile_photo_url }}" />
            @else
                <img src="{{ Auth::user()->adminlte_image() }}"
                class="user-image img-circle elevation-2"
                alt="{{ Auth::user()->profile_photo_url }}">
            @endif
        @endif
        <span @if(config('adminlte.usermenu_image')) class="d-none d-md-inline" @endif>
            {{ Auth::user()->name }}
        </span>
    </a>

    {{-- User menu dropdown --}}
    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

        {{-- User menu header --}}
        @if(!View::hasSection('usermenu_header') && config('adminlte.usermenu_header'))
            <li class="user-header {{ config('adminlte.usermenu_header_class', 'bg-primary') }}
                @if(!config('adminlte.usermenu_image')) h-auto @endif">
                @if(config('adminlte.usermenu_image'))
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <img class="img-circle elevation-2 img-fluid" src="{{ asset(Auth::user()->profile_photo_url) }}"
                          alt="{{ Auth::user()->profile_photo_url }}" />
                    @else
                        <img src="{{ Auth::user()->adminlte_image() }}"
                             class="img-circle elevation-2"
                             alt="{{ Auth::user()->profile_photo_url }}">
                    @endif
                @endif
                <p class="@if(!config('adminlte.usermenu_image')) mt-0 @endif">
                    {{ Auth::user()->name }}
                    @if(config('adminlte.usermenu_desc'))
                        <small>{{ Auth::user()->adminlte_desc() }}</small>
                    @endif
                </p>
            </li>
        @else
            @yield('usermenu_header')
        @endif

        {{-- Configured user menu links --}}
        @each('adminlte::partials.navbar.dropdown-item', $adminlte->menu("navbar-user"), 'item')

        {{-- User menu body --}}
        @hasSection('usermenu_body')
            <li class="user-body">
                @yield('usermenu_body')
            </li>
        @endif

        {{-- User menu footer --}}
        @auth
        <li class="user-footer">
            @if($profile_url)
                <a href="{{ $profile_url }}" class="btn btn-success btn-flat btn-sm">
                    <i class="fa fa-fw fa-user"></i>
                    {{ __('adminlte::menu.profile') }}
                </a>
            @endif
            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                @if($api_token_url)
                    <a href="{{ $api_token_url }}" class="btn btn-warning btn-flat btn-sm">
                        <i class="fab fa-quinscape"></i>
                        {{ __('adminlte::menu.token') }}
                    </a>
                @endif
            @endif
            <a class="btn btn-danger btn-flat btn-sm float-right @if(!$profile_url) btn-block @endif"
               href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-fw fa-power-off"></i>
                {{ __('adminlte::adminlte.log_out') }}
            </a>
            <form id="logout-form" action="{{ $logout_url }}" method="POST" style="display: none;">
                @if(config('adminlte.logout_method'))
                    {{ method_field(config('adminlte.logout_method')) }}
                @endif
                {{ csrf_field() }}
            </form>
        </li>
        @endauth

        {{-- Team-Management menu footer --}}
        @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
            @auth
            <li class="user-footer text-center
            {{ config('adminlte.usermenu_header_class', 'bg-primary') }}
            @if(!config('adminlte.usermenu_image')) h-auto @endif">
                {{ Auth::user()->currentTeam->name }}
            </li>
            <li class="user-footer">
                <a href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" class="btn btn-success btn-flat btn-sm float-left">
                    <i class="fas fa-users-cog"></i>
                    {{ __('adminlte::menu.team_settings') }}
                </a>

                @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                <a href="{{ route('teams.create') }}" class="btn btn-warning btn-flat btn-sm float-right">
                    <i class="far fa-plus-square"></i>
                    {{ __('adminlte::menu.create_new_team') }}
                </a>
                @endcan
            </li>
            <li class="user-footer text-center
            {{ config('adminlte.usermenu_header_class', 'bg-primary') }}
            @if(!config('adminlte.usermenu_image')) h-auto @endif">
                {{ __('adminlte::menu.switch_teams') }}
            </li>
            <li class="user-footer">
                @foreach (Auth::user()->allTeams() as $team)
                    <x-jet-switchable-team :team="$team" />
                @endforeach
            </li>
            @endauth
        @endif
    </ul>

</li>
