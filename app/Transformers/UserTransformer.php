<?php

namespace App\Transformers;

use App\User;
use Appkr\Api\TransformerAbstract;
use League\Fractal\ParamBag;

class UserTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include using url query string.
     * e.g. collection case -> ?include=comments:limit(5|1):sort(created_at|desc)
     *      item case       -> ?include=author
     *
     * @var  array
     */
    protected $availableIncludes = [
        'articles',
        'comments'
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
     * @param  \App\User $user
     * @return  array
     */
    public function transform(User $user)
    {
        $payload = [
            'id' => (int) $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => 'http:' . gravatar_profile_url($user->email),
            'signup' => $user->created_at->toIso8601String(),
            'link' => [
                 'rel' => 'self',
                 'href' => route('api.users.show', $user->id),
            ],
            'articles' => (int) $user->articles->count(),
            'comments' => (int) $user->comments->count(),
        ];

        return $this->buildPayload($payload);
    }

    /**
     * Include articles.
     *
     * @param  \App\User $user
     * @param  \League\Fractal\ParamBag|null $paramBag
     * @return  \League\Fractal\Resource\Collection
     */
    public function includeArticles(User $user, ParamBag $paramBag = null)
    {
        $transformer = new \App\Transformers\ArticleTransformer($paramBag);

        $articles = $user->articles()
            ->limit($transformer->getLimit())
            ->offset($transformer->getOffset())
            ->orderBy($transformer->getSortKey(), $transformer->getSortDirection())
            ->get();

        return $this->collection($articles, $transformer);
    }

    /**
     * Include comments.
     *
     * @param  \App\User $user
     * @param  \League\Fractal\ParamBag|null $paramBag
     * @return  \League\Fractal\Resource\Collection
     */
    public function includeComments(User $user, ParamBag $paramBag = null)
    {
        $transformer = new \App\Transformers\CommentTransformer($paramBag);

        $comments = $user->comments()
            ->limit($transformer->getLimit())
            ->offset($transformer->getOffset())
            ->orderBy($transformer->getSortKey(), $transformer->getSortDirection())
            ->get();

        return $this->collection($comments, $transformer);
    }
}
