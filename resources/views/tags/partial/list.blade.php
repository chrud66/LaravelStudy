<!-- resources/views/tags/partial/list.blade.php -->

@if($tags->count())
<span class="text-muted">{!! icon('tags') !!}</span>
<ul class="tags__forum">
    @foreach($tags as $tag)
    <li class="label label-default">
        <a href="#">
            {{ $tag->name }}
        </a>
    </li>
    @endforeach
</ul>
@endif