@extends('layout.layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Last users</h1>
            </div>
        </div>
        <div class="row">
            @foreach ($last_users as $last_user)
                <div class="col-2">
                    <div>
                        <img class="img-fluid " src="https://placehold.co/300x300" alt="{{ $last_user->username }}">
                    </div>
                    <div class="text-center ">{{ $last_user->username }}</div>
                    
                </div>
            @endforeach
        </div>
    </div>
@endsection