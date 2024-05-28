<!DOCTYPE html>
<html class="h-100" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @vite(['resources/sass/app.scss'])
    </head>
    <body class="d-flex flex-column h-100">
        @include('layout.includes.header')

        @yield('content')

        @include('layout.includes.footer')
        @vite(['resources/js/app.js'])
    </body>
</html>