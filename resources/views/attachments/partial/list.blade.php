<!-- resources/views/attachments/partial/list.blade.php -->
@if($attachments->count())
<ul class="tags__forum list-unstyled">
    @foreach($attachments as $attachment)
    <li class="label label-default mb-2">
        {!! icon('download') !!}
        <a href="/attachments/{{ $attachment->name }}">
            {{ $attachment->name }}
        </a>
        @if(auth()->user() and (auth()->user()->isAdmin() or $article->isAuthor()))
        <form action="{{ route('files.destroy', $attachment->id) }}" method="POST" style="display: inline;">
            {!! csrf_field() !!}
            {!! method_field('DELETE') !!}
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#confirmDeleteFile{{ $attachment->id }}">
                x
            </button>

            <div class="modal fade" id="confirmDeleteFile{{ $attachment->id }}" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmDeleteLabel">Delete File</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{ __('common.confirm_delete_file') }}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('common.close') }}</button>
                            <button type="submit" class="btn btn-primary">{{ __('common.delete') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @endif
    </li>
    @endforeach
</ul>
@endif