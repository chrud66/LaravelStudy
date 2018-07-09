<!-- resources/views/tags/partial/list.blade.php -->

@if($tags->count())
<span class="text-muted">{!! icon('tags') !!}</span>
<ul class="tags__forum list-unstyled list-inline-item">
    @foreach($tags as $tag)
    <li class="label label-default list-inline-item">
        <a href="{{ route('tags.articles.index', $tag->id)}}" class="badge badge-secondary">
            {{ $tag->name }}
        </a>
    </li>
    @endforeach
</ul>
@endif