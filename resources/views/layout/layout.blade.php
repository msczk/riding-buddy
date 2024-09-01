<!DOCTYPE html>
<html class="" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script>
            var txt_copied = "{{ __('Copied') }}";
        </script>

        @vite(['resources/sass/app.scss'])
        @yield('javascript')
    </head>
    <body id="@yield('body_id')" class="d-flex flex-column">
        @include('layout.includes.header')

        @yield('content')

        @include('layout.includes.fixed-menu')
        {{-- @include('layout.includes.footer') --}}
        @vite(['resources/js/app.js'])
    </body>
</html>