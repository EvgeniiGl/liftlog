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
