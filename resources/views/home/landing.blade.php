<!DOCTYPE html>
<html class="" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @vite(['resources/sass/app.scss'])
    </head>
    <body id="landing" class="d-flex flex-column justify-content-end">
        <div class="container">
            <div class="col-12 offset-lg-3 col-lg-6">
                <h1>
                    {{ __(':name, the app where you make friends and find roads around your location', ['name' => Config::get('app.name')]) }}
                </h1>
            </div>
            <div class="col-12 offset-lg-3 col-lg-6">
                <a class="btn btn-primary btn-register w-100" href="{{ route('auth.register') }}">{{ __('Get started') }}</a>
            </div>
            <div class="col-12 offset-lg-3 col-lg-6 text-center">
                <a class="btn-guest" href="{{ route('home') }}">{{ __('Continue as guest') }}</a>
            </div>
        </div>

        @vite(['resources/js/app.js'])
    </body>
</html>