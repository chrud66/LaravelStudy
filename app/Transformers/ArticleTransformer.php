<?php

namespace App\Transformers;

use App\Article;
use Appkr\Api\TransformerAbstract;
use League\Fractal\ParamBag;

class ArticleTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include using url query string.
     * e.g. collection case -> ?include=comments:limit(5|1):sort(created_at|desc)
     *      item case       -> ?include=author
     *
     * @var  array
     */
    // 클라이언트에서 /v1/articles?include=comments:limit(2|0):order(created_at|desc) 처럼
    // Nesting 된 하위 리소스를 JSON 응답에 포함할 때, 응답할 갯수와 정렬을 정의할 수 있다.
    protected $availableIncludes = ['comments', 'author', 'tags', 'attachments'];

    /**
     * List of resources to be included always.
     *
     * @var  array
     */
    protected $defaultIncludes = [];
    /**
     * List of attributes to respond.
     *
     * @var  array
     */
    protected $visible = [];

    /**
     * List of attributes NOT to respond.
     *
     * @var  array
     */
    protected $hidden = [];

    /**
     * Transform single resource.
     *
     * @param  \App\\Article $article
     * @return  array
     */
    public function transform(Article $article)
    {
        $id = optimus((int) $article->id);

        $payload = [
            'id' => $id,
            'title' => $article->title,
            'content_raw' => strip_tags($article->content), //HTML 태그 제거
            'content_html' => markdown($article->content), //마크다운으로 컴파일
            'created' => $article->created_at->toIso8601String(),
            'view_count' => (int) $article->view_count,
            'link' => [
                 'rel' => 'self',
                 'href' => route('api.v1.articles.show', $id), // URL
            ],
            'comments' => (int) $article->comments->count(), // 댓글 수
            'author' => sprintf('%s <%s>', $article->author->name, $article->author->email),
            'tags' => $article->tags->pluck('slug'), // ['laravel', 'eloquent', '...']
            'attachments' => (int) $article->attachments->count(), //첨부파일 수
        ];

        return $this->buildPayload($payload);
    }

    // $availableIncludes 에 정의된 값들에 대응되는 includeXxx 이름의 메소드를 모두 정의해 주어야 한다.
    // 이 메소드가 있어야 /v1/articles?include=comments 처럼 쿼리스트링을 통해서 하위 리소스를 포함하는 것이 가능해 진다.

    // /v1/articles?include=comments 처럼 QueryString 이 달려 있으면,
    // config('api.params.limit'), config('api.params.order') 에 정의한 개수와 정렬방식의 Collection 으로 응답된다.
    // Article 와 Comment 의 관계는 morphMany() 로 정의되어 있어,
    // Article 컨텍스트에서 Comment 는 항상 Collection 이 되어야 한다는 점을 상기하자.

    /**
     * Include comments.
     *
     * @param  \App\\Article $article
     * @param  \League\Fractal\ParamBag|null $paramBag
     * @return  \League\Fractal\Resource\Collection
     */
    public function includeComments(Article $article, ParamBag $paramBag = null)
    {
        $transformer = new \App\Transformers\CommentTransformer($paramBag);

        $comments = $article->comments()
            ->limit($transformer->getLimit())
            ->offset($transformer->getOffset())
            ->orderBy($transformer->getSortKey(), $transformer->getSortDirection())
            ->get();

        return $this->collection($comments, $transformer);
    }

    /**
     * Include author.
     *
     * @param  \App\\Article $article
     * @param  \League\Fractal\ParamBag|null $paramBag
     * @return  \League\Fractal\Resource\Item
     */
    // 얘는 belongsTo() 관계라 Item 을 응답한다.
    // Simple Transformer 구현에서 봤던 내용과 크게 다르지 않다.
    public function includeAuthor(Article $article, ParamBag $paramBag = null)
    {
        return $this->item(
            $article->author,
            new \App\Transformers\AuthorTransformer($paramBag)
        );
    }

    /**
     * Include tags.
     *
     * @param  \App\\Article $article
     * @param  \League\Fractal\ParamBag|null $paramBag
     * @return  \League\Fractal\Resource\Collection
     */
    // 역시 마찬가지. 위에서 Transform 한대로 배열 형태의 Tag Slug 들만 나가지만,
    // ?include=tags 이 있다면 Tag Collection 이 JSON 배열로 반환될 것이다.
    public function includeTags(Article $article, ParamBag $paramBag = null)
    {
        $transformer = new \App\Transformers\TagTransformer($paramBag);

        $tags = $article->tags()
            ->limit($transformer->getLimit())
            ->offset($transformer->getOffset())
            ->orderBy($transformer->getSortKey(), $transformer->getSortDirection())
            ->get();

        return $this->collection($tags, $transformer);
    }

    /**
     * Include attachments.
     *
     * @param  \App\\Article $article
     * @param  \League\Fractal\ParamBag|null $paramBag
     * @return  \League\Fractal\Resource\Collection
     */
    // Article 과 Attachment 는 hasMany 관계로 연결되어 있기 때문에 Collection 을 응답하는게 맞다.
    public function includeAttachments(Article $article, ParamBag $paramBag = null)
    {
        $transformer = new \App\Transformers\AttachmentTransformer($paramBag);

        $attachments = $article->attachments()
            ->limit($transformer->getLimit())
            ->offset($transformer->getOffset())
            ->orderBy($transformer->getSortKey(), $transformer->getSortDirection())
            ->get();

        return $this->collection($attachments, $transformer);
    }
}
