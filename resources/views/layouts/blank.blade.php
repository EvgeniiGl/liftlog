<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.head')
    {!! shared()->render() !!}
</head>
<body>
<div class="main-container">

    <header class="">
        @include('layouts.header-blank')
    </header>

    <div id="main" class="">

        @yield('content')

    </div>

    <footer class="row container page-footer font-small blue" id="footer">
        @if(Session::has('message'))
            <div
                class="w-100 position-absolute alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</div>
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









