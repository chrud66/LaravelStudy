<!-- resources/views/users/partial/avatar.blade.php -->

@if($user)
<a href="{{ gravatar_profile_url($user->email) }}" class="pull-left hidden-xs hidden-sm">
    <img src="{{ gravatar_url($user->email, 64) }}" alt="{{ $user->name }}" class="media-object">
</a>
@else
<a href="{{ gravatar_profile_url('chrud66@example.com') }}" class="pull-left hidden-xs hidden-sm">
    <img src="{{ gravatar_url('chrud66@example.com', 64) }}" alt="Unknown User" class="media-object">
</a>
@endif