<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\Naver\NaverExtendSocialite;
use SocialiteProviders\Kakao\KakaoExtendSocialite;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
        SocialiteWasCalled::class => [
            NaverExtendSocialite::class,
            KakaoExtendSocialite::class,
        ],
        \App\Events\ArticleConsumed::class => [
            \App\Listeners\ViewCountHandler::class
        ],
        \App\Events\ModelChanged::class => [
            \App\Listeners\CacheHandler::class
        ]
    ];
    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        'App\Listeners\UserEventsHandler',
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Event::listen('comments.*', \App\Listeners\CommentsHandler::class);
        //Event::listen('comments.created', \App\Listeners\CommentsHandler::class);
        //Event::listen('comments.updated', \App\Listeners\CommentsHandler::class);
    }
}
