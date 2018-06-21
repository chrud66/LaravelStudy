@extends('layouts.master')

@section('content')
<header class="page-header pb-2 mt-4 mb-2 border-bottom">
    Documents Viewer
</header>

<div class="row">
    <div class="col-md-3 sidebar__documents">
        <aside>
            {!! $index !!}
        </aside>
    </div>
</div>

<div class="col-md-9 article__documents">
    <article id="article">
        {!! $content !!}
    </article>
</div>
@endsection