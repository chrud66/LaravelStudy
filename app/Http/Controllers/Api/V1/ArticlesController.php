<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
//use App\Http\Controllers\Controller;
use App\Http\Controllers\ArticlesController as ParentController;
use App\Transformers\ArticleTransformer;
use App\Article;

class ArticlesController extends ParentController
{
    public function __construct()
    {
         // 'auth' 대신 'jwt.auth' 미들웨어를 사용하는데, 미들웨어를 적용시키지 않을 메소드는 동일하다.
        // 읽기 요청인 'index' 와 'show' 를 제외했는데, 나중에 Rate Limit 로 시간당 요청 가능 횟수를 제한할 것이다.
        $this->middleware('jwt.auth', ['except' => ['index', 'show']]);
        $this->middleware('throttle.api:60,1');

        parent::__construct();
    }

    // 부모 클래스를 Override 해서 JSON 응답을 반환한다.
    protected function respondCollection(LengthAwarePaginator $articles)
    {
        return json()->withPagination($articles, new ArticleTransformer);
    }

    protected function respondCreated(Article $article)
    {
        return json()->created();
    }

    protected function respondItem(Article $article, Collection $commentsCollection = null)
    {
        return json()->withItem($article, new ArticleTransformer);
    }

    protected function respondUpdated(Article $article)
    {
        return json()->success('Updated');
    }

    protected function respondDeleted(Article $article)
    {
        return json()->noContent();
    }
}
