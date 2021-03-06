@extends('layouts.app')

@section('content')
<h1>{{ $user->name }}</h1>
<a href="/{{ $user->username }}/follows" class="bnt btn-link">
    Sigue a <span class="badge badge-secondary">{{ $user->follows->count() }}</span>
</a>
<a href="/{{ $user->username }}/followers" class="btn btn-link">
    Seguidores <span class="badge badge-secondary">{{ $user->followers->count() }}</span>
</a>
@if(Auth::check())

@if(Gate::allows('dms', $user))
    <form action="/{{ $user->username }}/dms" method="POST">
        {{csrf_field() }}
        <input type="text" class="form-control" name="message">
        <button class="btn btn-success" type="submit">Enviar dms</button>
    </form>
@endif

    @if(Auth::User()->isFollowing($user))

    <form action="/{{$user->username}}/unfollow" method="post">
        {{ csrf_field() }}
        @if(session('success'))
        <span class="text-success"> {{session('success')}} </span>
        @endif
        <button class="btn btn-danger">Dejas de seguir</button>
    </form>
    @else
        <form action="/{{$user->username}}/follow" method="post">
            {{ csrf_field() }}
            @if(session('success'))
            <span class="text-success"> {{session('success')}} </span>
            @endif
            <button class="btn btn-primary">Seguir </button>
        </form>
    @endif

@endif
<div class="row">
@foreach($user->messages as $message)
    <div class="col-md-6">
        @include('messages.message')
    </div>
@endforeach
</div>
@endsection 