<?php

namespace App\Transformers;

use App\Tag;
use Appkr\Api\TransformerAbstract;
use League\Fractal\ParamBag;

class TagTransformer extends TransformerAbstract {
    /**
     * List of resources possible to include using url query string.
     * e.g. collection case -> ?include=comments:limit(5|1):sort(created_at|desc)
     *      item case       -> ?include=author
     *
     * @var  array
     */
    protected $availableIncludes = [
        'articles'
    ];

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
     * @param  \App\Tag $tag
     * @return  array
     */
    public function transform(Tag $tag)
    {
        $payload = [
            'id' => (int) $tag->id,
            'slug' => $tag->slug,
            'created' => $tag->created_at->toIso8601String(),
            'link' => [
                 'rel' => 'self',
                 'href' => route('api.v1.tags.articles.index', $tag->slug),
            ],
            'articles' => (int) $tag->articles->count(),
        ];

        return $this->buildPayload($payload);
    }

    /**
     * Include articles.
     *
     * @param  \App\Tag $tag
     * @param  \League\Fractal\ParamBag|null $paramBag
     * @return  \League\Fractal\Resource\Collection
     */
    public function includeArticles(Tag $tag, ParamBag $paramBag = null)
    {
        $transformer = new \App\Transformers\ArticleTransformer($paramBag);

        $articles = $tag->articles()
            ->limit($transformer->getLimit())
            ->offset($transformer->getOffset())
            ->orderBy($transformer->getSortKey(), $transformer->getSortDirection())
            ->get();

        return $this->collection($articles, $transformer);
    }
}
