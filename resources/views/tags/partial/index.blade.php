<!-- resource/tags/partial/index.blade.php -->
<p class="lead">
    {!! icon('tags') !!} Tags
</p>

<ul class="list-unstyled">
    @foreach($allTags as $tag)
    <li class="{{ (Route::current()->parameter('id') == $tag->id) ? 'active' : '' }}">
        <a href="#">
            {{ $tag->name }}
            @if($tagCount = $tag->articles->count())
                <span class="badge badge-default">
                    {{ $tagCount }}
                </span>
            @endif
        </a>
    </li>
    @endforeach
</ul>