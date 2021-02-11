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
        <div class="card-body d-none">
            <form action="{{ route('replies.update', $reply) }}" method="post">
                @csrf
                @method('put')
                <div class="form-group">
                    <textarea class="form-control" name="body" rows="5">{{ $reply->body }}</textarea>
                </div>
                <button type="submit" class="btn btn-sm btn-info">Update</button>
                <span class="btn btn-sm btn-warning replyEditCancel">Cancel</span>
            </form>
        </div>
        @can('update', $reply)
            <div class="card-footer level">
                <button class="btn btn-sm btn-primary mr-1 replyEdit" data-id="{{ $reply->id }}"
                        data-text="{{ $reply->body }}">Edit
                </button>
                <form action="{{ route('replies.destroy', $reply) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </div>
        @endcan
    </div>
@endforeach
