<x-layouts.base>

    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('fuel.modify') }}">
                <img src="/logo.png" alt="..." height="36">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    @auth
                        <li class="nav-item dropdown">

                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ __('Fuel Management') }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('fuel.modify') }}">
                                    {{ __('View') }}
                                </a>

                                </a>
                                @role('Super Admin')
                                    <a class="dropdown-item" href="{{ route('local') }}">
                                        {{ __('Local Trucks Kms') }}
                                    </a>
                                @endrole
                                <a class="dropdown-item" href="{{ route('analysis') }}">
                                    {{ __('Analysis') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('reports') }}">
                                    {{ __('Report') }}
                                </a>
                            </div>
                        </li>
                        @role(['Admin', 'Super Admin'])
                            <li class="nav-item">

                                <a i class="nav-link" href="{{ route('gen.lpo') }}" role="button">
                                    {{ __('Generate LPO') }}
                                </a>
                            </li>
                        @endrole
                        @role('Super Admin')
                            <li class="nav-item dropdown">

                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ __('Master Data') }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('trucks') }}">
                                        {{ __('Trucks') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('routes') }}">
                                        {{ __('Routes') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('stations') }}">
                                        {{ __('Stations') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('comments') }}">
                                        {{ __('Comments') }}
                                    </a>
                                </div>
                            </li>
                        @endrole

                        @role('Super Admin')
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ __('Import') }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('import.routes') }}">
                                        {{ __('Import Routes Info') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('import.trucks') }}">
                                        {{ __('Import Trucks Info') }}
                                    </a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ __('Manage') }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('users.index') }}">
                                        {{ __('Users') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('roles.index') }}">
                                        {{ __('Roles') }}
                                    </a>
                                </div>
                            </li>
                        @endrole
                    @endauth
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        {{ $slot }}
    </main>
</x-layouts.base>
