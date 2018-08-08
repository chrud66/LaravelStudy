<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\ArticlesRequest;
use App\Http\Requests\FilterArticlesRequest;
use App\Article;
use App\Events\ArticleConsumed;
use App\Events\ModelChanged;
use App\Tag;

class ArticlesController extends Controller implements Cacheable
{
    protected $cache;

    public function __construct()
    {
        $this->middleware('author:article', ['only' => ['update', 'destroy', 'pickBest']]);

        if (! is_api_request()) {
            // \App\Http\Controllers\Api\V1\ArticlesController 에서 이 컨트롤러를 상속할 것이므로,
            // API 에 필요 없는 부분은 (! is_api_request()) 로 제외 시켰다.
            $this->middleware('auth', ['except' => ['index', 'show']]);

            view()->share('allTags', Tag::with('articles')->get());
        }

        // taggable() Helper 를 이용하여 기본 쿼리를 만든다.
        // .env 에 CACHE_DRIVER= 값이 file 이나 database 이면 Cache Tag 를 쓸 수 없다.
        $this->cache = taggable()
            ? app('cache')->tags('articles')
            : app('cache');
    }

    public function cacheKeys()
    {
        return 'articles';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FilterArticlesRequest $request, $id = null)
    {
        $query = $id ? \App\Tag::findOrFail($id)->articles() : new Article;
        // cache_key() Helper 를 이용해 캐시에 사용할 고유한 key 를 만든다.
        $cacheKey = cache_key('articles.index');
        $query = $this->filter($query->orderBy('pin', 'desc'));
        $param = $request->input(config('project.params.limit'), 5);

        $articles = $this->cache($cacheKey, 5, $query, 'paginate', $param);


        //기존 코드
        //$query = $id ? \App\Tag::findOrFail($id)->articles() : new Article;
        //$articles = $this->cache->remember($cacheKey, 5, function() use ($query, $request) {
        //    return $this->filter($query)->paginate($request->input('pp', 5));
        //});
        //return view('articles.index', compact('articles'));

        return $this->respondCollection($articles);
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
        $payload = $this->getBooleanColumn($request);

        $article = $request->user()->articles()->create($payload);
        $article->tags()->sync($request->input('tags'));

        if ($request->has('attachments')) {
            $attachments = \App\Attachment::whereIn('id', $request->input('attachments'))->get();
            $attachments->each(function ($attachment) use ($article) {
                $attachment->article()->associate($article);
                $attachment->save();
            });
        };

        event(new ModelChanged(['articles', 'tags']));

        //flash()->success(__('forum.created'));
        //return redirect(route('articles.index'))->withInput();
        return $this->respondCreated($article);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $cacheKey = cache_key("articles.show.{$id}");
        $secondKey = cache_key("articles.show.{$id}.comments");

        $query = Article::with('comments', 'tags', 'attachments', 'solution')->findOrFail($id);
        $article = $this->cache($cacheKey, 5, $query, 'findOrFail', $id);

        $secondQuery = $article->comments()->with('replies')->withTrashed()->whereNull('parent_id')->latest();
        $commentsCollection = $this->cache($secondKey, 5, $secondQuery, 'get');

        /*$article = $this->cache->remember($cacheKey, 5, function () use ($id) {
            return Article::with('comments', 'tags', 'attachments', 'solution')->findOrFail($id);
        });

        $commentsCollection = $this->cache->remember($secondKey, 5, function () use ($article) {
            return $article->comments()->with('replies')->withTrashed()->whereNull('parent_id')->latest()->get();
        });
        */

        if (! is_api_request()) {
            event(new ArticleConsumed($article));
        }

        return $this->respondItem($article, $commentsCollection, $cacheKey.$secondKey);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::with('attachments')->findOrFail($id);

        $filesInfo = [];

        foreach ($article->attachments as $attachment) {
            unset($obj);
            $obj = [];
            $path = attachment_path($attachment->name);
            if (\File::exists($path)) {
                $obj['id']      = $attachment->id;
                $obj['name']    = $attachment->name;
                $obj['size']    = \File::size($path);
                $obj['type']    = \File::mimeType($path);
                $obj['url']     = sprintf("/attachments/%s", $attachment->name);

                $filesInfo[] = $obj;
                //dump($obj);
            };
        };
        $filesInfo = json_encode($filesInfo ? $filesInfo : '{}');
        //dump($filesInfo);
        //exit;

        return view('articles.edit', compact('article', 'filesInfo'));
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
        $payload = $this->getBooleanColumn($request);

        $article = Article::findOrFail($id);
        $article->update($payload);
        // If Check 가 추가되었다. tags 필드를 넘기지 않으면 에러가 나므로...
        if ($request->has('tags')) {
            $article->tags()->sync($request->input('tags'));
        }

        //$request->input('notification') ? 1 : $request->request->add(['notification' => 0]);
        //$article->update($request->except('_token', '_method'));

        event(new ModelChanged(['articles', 'tags']));

        //flash()->success(__('forum.updated'));
        //return redirect(route('articles.index'))->withInput();
        return $this->respondUpdated($article);
    }

    //public function pickBest(Request $request, $id, $solution_id)
    public function pickBest(Request $request, $id)
    {
        $this->validate($request, [
            'solution_id' => 'required|numeric|exists:comments,id',
        ]);

        Article::findOrFail($id)->update([
            'solution_id' => $request->input('solution_id'),
            //'solution_id' => $solution_id,
        ]);

        return response()->json('', 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Article::findOrFail($id)->delete();
        $article = Article::with('attachments', 'comments')->findOrFail($id);

        foreach ($article->attachments as $attachment) {
            \File::delete(attachment_path($attachment->name));
        };

        $article->attachments()->delete();
        $article->comments->each(function ($comment) {
            app(\App\Http\Controllers\CommentsController::class)->recursiveDestroy($comment);
        });

        $article->delete();

        event(new ModelChanged('articles'));

        //flash()->success(__('forum.deleted'));
        //return redirect(route('articles.index'));
        return $this->respondDeleted($article);
    }

    protected function getBooleanColumn(ArticlesRequest $request) {
        return array_merge($request->except('_token'), [
            'notification' => $request->has('notification'),
            'pin' => $request->has('pin')
        ]);
    }

    protected function respondCollection(LengthAwarePaginator $articles, $cacheKey = null)
    {
        return view('articles.index', compact('articles'));
    }

    protected function respondCreated(Article $article)
    {
        flash()->success(__('forum.created'));
        return redirect(route('articles.index'))->withInput();
    }

    protected function respondItem(Article $article, Collection $commentsCollection = null, $cacheKey = null)
    {
        return view('articles.show', [
            'article'           => $article,
            'comments'          => $commentsCollection,
            'commentableType'   => Article::class,
            'commentableId'     => $article->id,
        ]);
    }

    protected function respondUpdated(Article $article)
    {
        flash()->success(__('forum.updated'));
        return redirect(route('articles.index'))->withInput();
    }

    protected function respondDeleted(Article $article)
    {
        flash()->success(__('forum.deleted'));
        return redirect(route('articles.index'));
    }
}
