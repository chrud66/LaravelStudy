<!-- resources/views/layouts/partial/flash_message.blade.php -->

@if (session()->has('flash_notification'))
    @foreach (session('flash_notification', collect())->toArray() as $message)
    <div class="container">
        <div class="alert alert-{{ $message['level'] }} alert-dismissible flash_message" role="alert">
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
            {!! $message['message'] !!}
        </div>
    </div>
    @endforeach
@endif

@if ($errors->has(null))
<div class="container">
    <div class="alert alert-danger alert-dismissable flash-message" role="alert">
        <button type="button" class="close" data-dismiss="alert">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
        </button>
        {{ __('common.msg_whoops') }}
    </div>
</div>
@endif