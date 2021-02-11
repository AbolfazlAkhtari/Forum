@if($message = Session::get('success'))
    <div class="customAlert alert alert-success" role="alert">
        <strong style="padding-right: 5px;">{!! $message !!}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@elseif($message = Session::get('warning'))
    <div class="customAlert alert alert-warning" role="alert">
        <strong style="padding-right: 5px;">{!! $message !!}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@elseif($message = Session::get('info'))
    <div class="customAlert alert alert-info" role="alert">
        <strong style="padding-right: 5px;">{!! $message !!}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@elseif($message = Session::get('danger'))
    <div class="customAlert alert alert-danger" role="alert">
        <strong style="padding-right: 5px;">{!! $message !!}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@elseif($errors->any())
    <div class="customAlert alert alert-danger" role="alert">
        @foreach($errors->all() as $key => $error)
            @if ($key != 0)
                <br>
            @endif
            <strong style="padding-right: 5px;"> {{ $error }} </strong>
        @endforeach
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

{{-- non sesstion template to use in ajax requests --}}
<div id="AjaxAlert" class="customAlert alert d-none" role="alert">
    <strong style="padding-right: 5px;" id="AjaxAlertMessage"></strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
