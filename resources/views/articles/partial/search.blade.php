<!-- resources/views/layouts/partial/search.blade.php -->
<div class="form-group mb-4 mt-3">
    <form action="{{ route('articles.index') }}" method="get" role="search" id="search__forum">
        <input type="text" name="q" class="form-control" value="{{ Input::get('q', '') }}" placeholder="Search" required minlength="2" />
    </form>
</div>