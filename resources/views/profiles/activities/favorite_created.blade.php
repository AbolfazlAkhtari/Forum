@component('profiles.activities.activity')
    @slot('header')
        <a href="{{ $activity->subject->favorited->path() }}">
            &nbsp;{{ $profileUser->name }} favorited a reply
        </a>
    @endslot
    @slot('body')
        {{ $activity->subject->favorited->body }}
    @endslot
@endcomponent
