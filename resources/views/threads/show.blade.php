@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header level">
                        <div class="flex">
                            <a href={{ route('userProfile.show', $thread->user->name) }}>
                                {{ $thread->user->name }}
                            </a> posted {{ $thread->title }}
                        </div>
                        @can('update', $thread)
                            <form action="{{ route('threads.destroy', $thread) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-link">Delete Thread</button>
                            </form>
                        @endcan
                    </div>
                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>
                @include('threads.reply')
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
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('.replyEdit').on("click", function () {
                $($(this).parent().siblings()[1]).addClass('d-none');
                $($(this).parent().siblings()[2]).removeClass('d-none')
            });
            $('.replyEditCancel').on("click", function () {
                $($($(this).parent()).parent()).addClass('d-none');
                $($($($(this).parent()).parent()).siblings()[1]).removeClass('d-none');
            });
        });
    </script>
@endsection
