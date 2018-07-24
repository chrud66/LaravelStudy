<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Vote;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('author:comment', ['except' => ['store', 'vote']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'commentable_type'  => 'required|in:App\Article',
            'commentable_id'    => 'required|numeric',
            'parent_id'         => 'numeric|exists:comments,id',
            'content'           => 'required',
        ]);

        $parentModel = "\\" . $request->input('commentable_type');
        $comment = $parentModel::find($request->input('commentable_id'))
            ->comments()->create([
                'author_id' => \Auth::user()->id,
                'parent_id' => $request->input('parent_id', null),
                'content'   => $request->input('content')
            ]);

        event('comments.created', [$comment]);

        flash()->success(__('forum.comment_add'));

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, ['content' => 'required']);

        $comment = Comment::findOrFail($id);
        $comment->update($request->only('content'));

        event('comments.updated', [$comment]);

        flash()->success(__('forum.comment_edit'));

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //$comment = Comment::find($id);
        //$this->recursiveDestroy($comment);
        $comment = Comment::with('replies')->find($id);
        if ($comment->replies->count() > 0) {
            $comment->delete();
        } else {
            $comment->forceDelete();
        }

        if ($request->ajax()) {
            return response()->json('', 204);
        }

        flash()->success(__('forum.deleted'));
        return back();
    }

    public function recursiveDestroy(Comment $comment)
    {
        if ($comment->replies->count()) {
            $comment->replies->each(function ($reply) {
                if ($reply->replies->count()) {
                    $this->recursiveDestroy($reply);
                } else {
                    $reply->delete();
                };
            });
        };

        $comment->delete();
    }

    public function vote(Request $request, $id)
    {
        $this->validate($request, [
            'vote' => 'required|in:up,down',
        ]);

        if (Vote::whereCommentId($id)->whereUserId($request->user()->id)->exists()) {
            // 사용자가 브라우저의 Inspector 등을 이용해서 disabled 된 투표 버튼을 다시 활성화시켜
            // 중복 투표를 하는 것을 방지하기 위한 조치이다.
            return response()->json(['errors' => 'Already voted!'], 409);
        }

        $comment = Comment::findOrFail($id);
        $up = $request->input('vote') == 'up' ? true : false;

        $comment->votes()->create([
            'user_id'   => $request->user()->id,
            'up'        => $up ? 1 : null,
            'down'      => $up ? null : 1,
            'voted_at'  => \Carbon\Carbon::now()->toDateTimeString(),
        ]);

        return response()->json([
            // up, down 어떤 투표인지와 투표 후 총 투표 수를 반환하고,
            // 뷰의 자바스크립트에서 총 투표 수를 업데이트한다.
            'voted' => $request->input('vote'),
            'value' => $comment->votes()->sum($request->input('vote')),
        ]);
    }
}
