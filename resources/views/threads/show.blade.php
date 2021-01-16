@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="#">
                            {{ $thread->user->name }}
                        </a> posted {{ $thread->title }}
                    </div>
                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-7">
                @foreach($thread->replies as $reply)
                    <br>
                    <div class="card">
                        <div class="card-header">
                            <a href="#">
                                {{ $reply->user->name }}
                            </a> said {{ $reply->created_at->diffForHumans() }}
                        </div>
                        <div class="card-body">
                            {{ $reply->body }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @auth()
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <br>
                    <form method="post" action="{{ route('replies.store', $thread->id) }}">
                        @csrf
                        <div class="form-group">
                            <textarea name="body" rows="5" class="form-control" placeholder="Have something to say?"></textarea>
                        </div>
                        <button class="btn btn-primary" type="submit">Post</button>
                    </form>
                </div>
            </div>
        @else
            <br>
            <p class="text-center">Please <a href="{{ route('login') }}">Sign in</a> to participate in this thread</p>
        @endauth
    </div>
@endsection
