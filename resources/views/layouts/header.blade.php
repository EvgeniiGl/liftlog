<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand font-italic" href="/">LIFTLOG</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active"></li>
            <a class="nav-link" href="{{ url('/records') }}">Журнал
            </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/address') }}">Объекты</a>
            </li>
            {{--                   <li class="nav-item">--}}
            {{--              <a class="nav-link" href="{{ url('/firms') }}">Организации</a>--}}
            {{--            </li>--}}
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/users')}}">Персонал</a>
            </li>
            {{--        personal cabinet disabled      --}}
            {{--            <li class="nav-item">--}}
            {{--                <a class="nav-link" href="{{ url('/personal')}}">Личный кабинет</a>--}}
            {{--            </li>--}}
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/statistic')}}">Статистика</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/service')}}">Сервис</a>
            </li>
        </ul>
    </div>
    <div>
        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Вход') }}</a>
                    </li>
                @endif
                @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Регистрация') }}</a>
                    </li>
                @endif
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Выйти') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</nav>
