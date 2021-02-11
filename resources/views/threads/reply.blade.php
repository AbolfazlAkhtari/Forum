@foreach($replies as $reply)
    <br>
    <div class="card" id="reply-{{$reply->id}}">
        <div class="card-header level">
            <div class="flex">
                <a href="{{ route('userProfile.show', $reply->user->name) }}">
                    {{ $reply->user->name }}
                </a> said {{ $reply->created_at->diffForHumans() }}
            </div>
            <form action="{{ route('replyFavorites.store', $reply) }}" method="post">
                @csrf
                <button type="submit"
                        class="btn btn-outline-secondary {{ $reply->isFavorited() ? 'disabled' : '' }}">{{ $reply->favorites_count }} {{ Str::plural('favorites', $reply->favorites_count) }}</button>
            </form>
        </div>
        <div class="card-body">
            {{ $reply->body }}
        </div>
        @can('update', $reply)
            <div class="card-footer">
                <form action="{{ route('replies.destroy', $reply) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </div>
        @endcan
    </div>
@endforeach
