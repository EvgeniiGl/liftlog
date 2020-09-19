<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.head')
    {!! shared()->render() !!}
</head>
<body>
<div class="main-container">

    <header class="">
        @include('layouts.header')
    </header>

    <div id="main" class="">

        @yield('content')

    </div>

    {{--    @if (Session::has('msg_success'))--}}
    {{--        <div id="msg_success" class="alert alert-success">{{ Session::get('msg_success') }}</div>--}}
    {{--    @endif--}}
    {{--    @if (Session::has('msg_error'))--}}
    {{--        <div id="msg_error" class="alert alert-danger">{{ Session::get('msg_error') }}</div>--}}
    {{--    @endif--}}

    <footer class="row container page-footer font-small blue" id="footer">
        @if(Session::has('message'))
            <div class="w-100 position-absolute alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</div>
        @endif
        @include('layouts.footer')
    </footer>

</div>
{{--GLOBAL REACT COMPONENTS --}}
<div id="root"></div>
{{--GLOBAL REACT COMPONENTS END --}}
<script src="{{'js/app.js' }}"></script>
</body>
</html>









