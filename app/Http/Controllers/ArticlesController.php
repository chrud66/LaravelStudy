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

class ArticlesController extends Controller
{

    public function __construct()
    {
        $this->middleware('author:article', ['only' => ['update', 'destroy', 'pickBest']]);

        if  (! is_api_request()) {
            // \App\Http\Controllers\Api\V1\ArticlesController 에서 이 컨트롤러를 상속할 것이므로,
            // API 에 필요 없는 부분은 (! is_api_request()) 로 제외 시켰다.
            $this->middleware('auth', ['except' => ['index', 'show']]);

            view()->share('allTags', Tag::with('articles')->get());
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FilterArticlesRequest $request, $id = null)
    {
        $query = $id ? \App\Tag::findOrFail($id)->articles() : new Article;

        //$query = $query->with('comments', 'author', 'tags', 'solution', 'attachments');
        $query = taggable()
            ? $query = $query->with('comments', 'author', 'tags', 'attachments')->remember(5)->cacheTags('articles')
            : $query = $query->with('comments', 'author', 'tags', 'solution', 'attachments')->remember(5);
        $articles = $this->filter($request, $query)->paginate(3);

        //return view('articles.index', compact('articles'));
        return $this->respondCollection($articles);
    }

    protected function filter($request, $query)
    {
        if ($filter = $request->input('f')) {
            // 'f' 쿼리 스트링 필드가 있으면, 그 값에 따라 쿼리를 분기한다.
            switch ($filter) {
                case 'nocomment':
                    $query->noComment();
                    break;
                case 'notsolved':
                    $query->notSolved();
                    break;
            }
        }

        if ($keyword = $request->input('q')) {
            // 이번에도 'q' 필드가 있으면 풀텍스트 검색 쿼리를 추가한다.
            $raw = 'MATCH(title,content) AGAINST(? IN BOOLEAN MODE)';
            $query->whereRaw($raw, [$keyword]);
        }


        // 's' 필드가 있으면 사용하고, 없으면 created_at 을 기본값으로 사용한다.
        $sort = $request->input('s', 'created_at');
        // 'd' 필드가 있으면 사용하고, 없으면 desc 를 기본값으로 사용한다.
        $direction = $request->input('d', 'desc');

        //return $query->orderBy($sort, $direction);
        return $query->orderBy('pin', 'desc')->orderBy($sort, $direction);
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
        $article = Article::with('comments', 'author', 'tags')->findOrFail($id);
        $commentsCollection = $article->comments()->with('replies', 'author')->withTrashed()->whereNull('parent_id')->latest()->get();

        event(new ArticleConsumed($article));

        /*return view('articles.show', [
            'article'           => $article,
            'comments'          => $commentsCollection,
            'commentableType'   => Article::class,
            'commentableId'     => $article->id,
        ]);*/

        return $this->respondItem($article, $commentsCollection);
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

    protected function respondCollection(LengthAwarePaginator $articles)
    {
        return view('articles.index', compact('articles'));
    }

    protected function respondCreated(Article $article)
    {
        flash()->success(__('forum.created'));
        return redirect(route('articles.index'))->withInput();
    }

    protected function respondItem(Article $article, Collection $commentsCollection = null)
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
