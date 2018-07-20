<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('author:comment', ['except' => ['store']]);
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
        $comment = Comment::find($id);
        $this->recursiveDestroy($comment);

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
}
