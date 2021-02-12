@foreach($replies as $reply)
    <br>
    <div class="card" id="reply-{{$reply->id}}">
        <div class="card-header level">
            <div class="flex">
                <a href="{{ route('userProfile.show', $reply->user->name) }}">
                    {{ $reply->user->name }}
                </a> said {{ $reply->created_at->diffForHumans() }}
            </div>
            @auth()
                <i class="fa-heart text-danger favoriteReply {{ $reply->isFavorited() ? 'fas' : 'far' }}" data-id="{{ $reply->id }}"> {{ $reply->favorites_count }}</i>
            @else
                <i class="fa-heart text-danger far"> {{ $reply->favorites_count }}</i>
            @endauth
{{--            <form action="{{ route('replyFavorites.store', $reply) }}" method="post">--}}
{{--                @csrf--}}
{{--                <button type="submit"--}}
{{--                        class="btn btn-outline-secondary {{ $reply->isFavorited() ? 'disabled' : '' }}">{{ $reply->favorites_count }} {{ Str::plural('favorites', $reply->favorites_count) }}</button>--}}
{{--            </form>--}}
        </div>
        <div class="card-body">
            {{ $reply->body }}
        </div>
        <div class="card-body d-none">
                <div class="form-group">
                    <textarea class="form-control" name="body" rows="5" data-id="{{ $reply->id }}">{{ $reply->body }}</textarea>
                </div>
                <button type="submit" class="btn btn-sm btn-info replyEditConfirm">Update</button>
                <span class="btn btn-sm btn-warning replyEditCancel">Cancel</span>
        </div>
        @can('update', $reply)
            <div class="card-footer level">
                <button class="btn btn-sm btn-primary mr-1 replyEdit" data-id="{{ $reply->id }}"
                        data-text="{{ $reply->body }}">Edit
                </button>
{{--                <form action="{{ route('replies.destroy', $reply) }}" method="post">--}}
{{--                    @csrf--}}
{{--                    @method('delete')--}}
                    <button type="submit" class="btn btn-sm btn-danger replyDelete" data-id="{{ $reply->id }}">Delete</button>
{{--                </form>--}}
            </div>
        @endcan
    </div>
@endforeach
