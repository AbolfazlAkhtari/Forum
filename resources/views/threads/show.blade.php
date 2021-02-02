@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href={{ route('userProfile.show', $thread->user->name) }}>
                            {{ $thread->user->name }}
                        </a> posted {{ $thread->title }}
                    </div>
                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>
                @foreach($replies as $reply)
                    <br>
                    <div class="card">
                        <div class="card-header level">
                            <div class="flex">
                                <a href="{{ route('userProfile.show', $reply->user->name) }}">
                                    {{ $reply->user->name }}
                                </a> said {{ $reply->created_at->diffForHumans() }}
                            </div>
                            <form action="{{ route('replyFavorites.store', $reply) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-outline-secondary {{ $reply->isFavorited() ? 'disabled' : '' }}">{{ $reply->favorites_count }} {{ Str::plural('favorites', $reply->favorites_count) }}</button>
                            </form>
                        </div>
                        <div class="card-body">
                            {{ $reply->body }}
                        </div>
                    </div>
                @endforeach
                <br>
                {{ $replies->links("pagination::bootstrap-4") }}
                @auth()
                    <div class="col-md-10 offset-1">
                        <br>
                        <form method="post" action="{{ route('replies.store', $thread->id) }}">
                            @csrf
                            <div class="form-group">
                                <textarea name="body" rows="5" class="form-control"
                                          placeholder="Have something to say?"></textarea>
                            </div>
                            <button class="btn btn-primary" type="submit">Post</button>
                        </form>
                    </div>
                @else
                    <br>
                    <p class="text-center">Please <a href="{{ route('login') }}">Sign in</a> to participate in this
                        thread</p>
                @endauth
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        This thread was published {{ $thread->created_at->diffForHumans() }} by <a
                            href="#">{{ $thread->user->name }}</a> and
                        has {{ $thread->replies_count }} {{ Str::plural('comment', $thread->replies_count) }}.
                    </div>
                </div>
            </div>
        </div>
@endsection
