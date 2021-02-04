@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>{{ $profileUser->name }}
            <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
        </h1>
        <hr>
        <div class="col-8">
            @foreach($threads as $thread)
                <div class="card">
                    <div class="card-header level">
                        <a href="{{ route('threads.show', [$thread->channel, $thread]) }}" class="flex">
                            {{ $thread->title }}
                        </a>
                        <span>
                            {{ $thread->created_at->diffForHumans() }}
                        </span>
                    </div>
                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>
                <br>
            @endforeach
            {{ $threads->links("pagination::bootstrap-4") }}
        </div>
    </div>
@endsection
