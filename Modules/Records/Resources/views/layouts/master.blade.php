
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Module Records</title>

       {{-- Laravel Mix - CSS File --}}
{{--        <link rel="stylesheet" href="{{ mix('css/records.css') }}">--}}

    </head>
    <body>
        @yield('content')

        {{-- Laravel Mix - JS File --}}
{{--         <script src="{{ mix('js/app.js', '') }}"></script>--}}
{{--         <script src="{{ mix('js/main.js', '') }}"></script>--}}

        <script src="{{ mix('js/main.js') }}"></script>
    </body>
</html>
