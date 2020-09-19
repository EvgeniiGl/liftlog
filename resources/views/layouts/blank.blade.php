<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.head')
</head>
<body>
<div class="container">
{{--    <div class="">--}}
{{--        @if (Route::has('login'))--}}
{{--            <div class="top-right links">--}}
{{--                @auth--}}
{{--                    <a href="{{ url('/home') }}">Home</a>--}}
{{--                @else--}}
{{--                    <a href="{{ route('login') }}">Login</a>--}}

{{--                    @if (Route::has('register'))--}}
{{--                        <a href="{{ route('register') }}">Register</a>--}}
{{--                    @endif--}}
{{--                @endauth--}}
{{--            </div>--}}
{{--        @endif--}}
{{--    </div>--}}

    <div id="main" class="row">

        @yield('content')

    </div>

    <footer class="row">
        @include('layouts.footer')
    </footer>

</div>
<script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>









