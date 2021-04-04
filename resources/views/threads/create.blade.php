@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create a new Thread</div>
                    <div class="card-body">
                        <form method="post" action="{{ route('threads.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="channel_id">Channel</label>
                                <select name="channel_id" id="channel_id" class="form-control">
                                    @foreach ($channels as $channel)
                                        <option value="{{ $channel->id }}">{{ $channel->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}">
                            </div>
                            <div class="form-group">
                                <label for="body">Body</label>
                                <textarea name="body" id="body" rows="8" class="form-control">{{ old('body') }}</textarea>
                            </div>
                            <button class="btn btn-primary">Publish</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
