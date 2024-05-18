<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>
    <body>
        @include('layout.includes.header')

        @yield('content')

        @include('layout.includes.footer')
    </body>
</html>