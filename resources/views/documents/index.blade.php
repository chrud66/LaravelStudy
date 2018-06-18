@extends('layouts.master')

@section('content')
<header class="page-header">
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
    <article>
        {!! $content !!}
    </article>
</div>
@endsection