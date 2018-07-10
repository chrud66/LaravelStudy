<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Http\Requests\ArticlesRequest;
use App\Article;

class ArticlesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware('accessible', ['except' => ['index', 'show', 'create', 'store']]);
        view()->share('allTags', \App\Tag::with('articles')->get());
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = null)
    {
        //$articles = Article::with('comments', 'author', 'tags')->latest()->paginate(5);
        $query = $id ? \App\Tag::find($id)->articles() : new Article;
        $articles = $query->with('comments', 'author', 'tags')->latest()->paginate(5);

        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $article = new Article;

        return view('articles.create', compact('article'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticlesRequest $request)
    {
        //$request->input('notification') ? 1 : //$request->request->add(['notification' => 0]);
        //$article = Article::create($request->all());

        $request->request->add(['author_id' => \Auth::user()->id]);
        $payload = array_merge($request->except('_token'), [
            'notification' => $request->has('notification')
        ]);

        $article = $request->user()->articles()->create($payload);
        $article->tags()->sync($request->input('tags'));

        if ($request->has('attachments')) {
            $attachments = \App\Attachment::whereIn('id', $request->input('attachments'))->get();
            $attachments->each(function ($attachment) use ($article) {
                $attachment->article()->associate($article);
                $attachment->save();
            });
        };

        flash()->success(__('forum.created'));

        return redirect(route('articles.index'))->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::with('comments', 'author', 'tags')->findOrFail($id);

        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id);

        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticlesRequest $request, $id)
    {
        $payload = array_merge($request->except('_token'), [
            'notification' => $request->has('notification')
        ]);

        $article = Article::findOrFail($id);
        $article->update($payload);
        $article->tags()->sync($request->input('tags'));

        //$request->input('notification') ? 1 : $request->request->add(['notification' => 0]);
        //$article->update($request->except('_token', '_method'));
        flash()->success(__('forum.updated'));

        return redirect(route('articles.index'))->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Article::findOrFail($id)->delete();
        flash()->success(__('forum.deleted'));

        return redirect(route('articles.index'));
    }
}