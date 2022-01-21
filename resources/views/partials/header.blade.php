<x-navbar :brand-url="url('/')">
    <x-slot name="content">
        @auth
            <ul class="navbar-nav me-auto">
                <!-- Application Navigation Links -->
            </ul>
        @endauth
        <ul class="navbar-nav ms-auto">
            @guest
                @if(Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link{{ Route::is('login') ? ' active' : '' }}" href="{{ route('login') }}" aria-current="{{ Route::is('login') ? 'page' : 'false' }}">
                            <span>{{ __('Login') }}</span>
                        </a>
                    </li>
                @endif
            @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="user-dropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span>{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="user-dropdown">
                        <x-dropdown-item href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</x-dropdown-item>
                    </ul>
                </li>
            @endguest
        </ul>
    </x-slot>
</x-navbar>
