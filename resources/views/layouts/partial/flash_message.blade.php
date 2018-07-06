<!-- resources/views/layouts/partial/flash_message.blade.php -->
@if (session()->has('flash_notification.message'))
<div class="container">
    <div class="alert alert-{{ session('flash_notification.level') }} alert-dismissible flash_message" role="alert">
        <button type="button" class="close" data-dismiss="alert">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
        </button>
        {{ session('flash_notification.message') }}
    </div>
</div>
@endif

@if ($errors->has(null))
<div class="container">
    <div class="alert alert-danger alert-dismissable flash-message" role="alert">
        <button type="button" class="close" data-dismiss="alert">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
        </button>
        {{ trans('common.msg_whoops') }}
    </div>
</div>
@endif