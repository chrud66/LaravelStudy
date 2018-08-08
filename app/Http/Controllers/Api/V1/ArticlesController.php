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
        //$this->middleware('throttle.api:60,1'); //Kernel.php에서 중복체크로 인하여 2회씩 감소한다 해결책으로 Kernel.php에 설정을 변경하여 전체 API 설정에 적용될 수 있도록 하였다
        $this->middleware('jwt.auth', ['except' => ['index', 'show']]);
        $this->middleware('obfuscate:article');

        parent::__construct();
    }

    // 부모 클래스를 Override 해서 JSON 응답을 반환한다.
    protected function respondCollection(LengthAwarePaginator $articles, $cacheKey = null)
    {
        //Request 붙어 온 If-None-Match Header 가져오기
        $reqEtag = request()->getETags();
        //베이스 클래스에서 만든 Collection에 대한 Etag 만들기
        $genEtag = $this->etags($articles, $cacheKey);

        if (config('project.cache') === true and isset($reqEtag[0]) and $reqEtag[0] and $reqEtag[0] === $genEtag) {
            // $reqEtag = ["65f8322657950bdccdc48df21dddfc33"] 이기 때문에 Array Access 해야 함.
            return $this->respondNotModified();
        }

        //클라이언트가 If-None-Match Header를 보내 오지 않았거나,
        //클라이언트가 보내온 Header 가 $genEtag 와 다를 경우.
        //즉, 모델이 수정되었을 경우
        return json()->setHeaders(['Etag' => $genEtag])->withPagination($articles, new ArticleTransformer);
    }

    protected function respondCreated(Article $article)
    {
        return json()->created();
    }

    protected function respondItem(Article $article, Collection $commentsCollection = null, $cacheKey = null)
    {
        $reqEtag = request()->getETags();
        //단일 Instance에 대한 Etag 만들기
        $genEtag = $article->etag($cacheKey);

        if (config('project.cache') === true and isset($reqEtag[0]) and $reqEtag[0] === $genEtag) {
            return $this->respondNotModified();
        }

        return json()->setHeaders(['Etag' => $genEtag])->withItem($article, new ArticleTransformer);
    }

    protected function respondUpdated(Article $article)
    {
        return json()->success('Updated');
    }

    protected function respondDeleted(Article $article)
    {
        return json()->noContent();
    }

    protected function respondNotModified()
    {
        return json()->notModified();
    }
}
