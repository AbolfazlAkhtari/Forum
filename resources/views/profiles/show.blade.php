@extends('layouts.app')
@section('content')
    <div class="container">
        <h1 class="header">{{ $profileUser->name }}
            <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
        </h1>
        <hr>
        <div class="col-8">
            @foreach($activities as $date => $activity)
                <h3 class="toast-header">{{ $date }}</h3>
                @foreach($activity as $record)
                    @include("profiles.activities.{$record->type}", ['activity' => $record])
                @endforeach
            @endforeach
        </div>
    </div>
@endsection
