<!-- resources/views/comments/index.blade.php -->
@section('style')
  <style>
    /* 2. 페이지 로드시 'comments.partial.comment' 에 포함된 현재 댓글 수정 폼, 대댓글 작성 폼은 표시되지 않는다. */
    div.media__create:not(:first-child),
    div.media__edit {
      display: none;
    }

    .none-after::after {
        content: "";
        border: 0px;
    }
  </style>
@endsection

<div class="container__forum">
    @if($currentUser)
        @include('comments.partial.create')
    @endif

    @forelse($comments as $comment)
        @include('comments.partial.comment', ['parentId' => $comment->id])
    @empty
    @endforelse
</div>

@section('script')
<script>
    $("button.btn__reply").on("click", function(e) {
        // 3. 'Reply' 버튼을 클릭하면 해당 댓글 아래에 대댓글 작성 폼이 토글(표시/숨김) 된다.
        // 해당 댓글에 수정 폼이 표시되어 있다면 숨긴다.
        var el__create = $(this).closest(".media__item").find(".media__create").first(),
        el__edit = $(this).closest(".media__item").find(".media__edit").first();

        el__edit.hide("fast");
        el__create.toggle("fast").end().find('textarea').focus();
    });

    $("button.btn__pick").on("click", function (e) {
        var articleId = $("#article__article").data("id"),
            commentId = $(this).closest(".media__item").data("id");

        if (confirm("{{ __('forum.msg_pick_best') }}")) {
            $.ajax({
               type: "POST",
               url: "/articles/" + articleId + "/pick",
               data: {
                   _method: "PUT",
                   solution_id: commentId
               },
               success: function(data) {
                   flash("success", "{{ __('common.updated') }} {{ __('common.msg_reload') }}", 1500);
                   reload(3000);
               }
            });
        }
    });

    $("a.btn__edit").on("click", function(e) {
        // 4. 'comments.partial.control' 조각 뷰에서 수정을 선택하면 해당 댓글 수정 폼이 표시된다.
        // 해당 댓글에 대댓글 작성폼이 표시되어 있다면 숨긴다.
        var el__create = $(this).closest(".media__item").find(".media__create").first(),
        el__edit = $(this).closest(".media__item").find(".media__edit").first();

        el__create.hide("fast");
        el__edit.toggle("fast").end().find('textarea').first().focus();
    });

    $("a.btn__delete").on("click", function(e) {
        // 5. 'comments.partial.control' 조각 뷰에서 삭제를 선택하면 해당 댓글 삭제 Ajax 이 나가고,
        // 삭제 성공시 플래시 메시지를 표시한다.
        var commentId = $(this).closest(".media__item").data("id");

        if (confirm("Are you sure to delete this comment?")) {
            $.ajax({
                type: "POST",
                url: "/comments/" + commentId,
                data: {
                    _method: "DELETE"
                },
                success : function(data) {
                    flash('success', 'Deleted ! The page will reload in 3 secs.', 2500);
                    reload(3000);
                }
            });
        };
    });
</script>
@endsection