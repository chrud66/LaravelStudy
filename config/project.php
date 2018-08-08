<?php

return [
    /*
    --------------------------------------------------------------
    | Enable or disable site-wide caching
    --------------------------------------------------------------
    | If set to false, site-wide cache and etag/304 feature will be disabled.
    | For production, for performance this should be set to true.
    */
    'cache' => ! env('APP_DEBUG', false),

    /*
    ---------------------------------------------------------------
    | Available/allowed fields for query string
    ---------------------------------------------------------------
     */
    'params' => [
        'page' => 'page',
        'filter' => 'filter',
        'limit' => 'limit',
        'sort' => 'sort',
        'order' => 'order',
        'search' => 'q',
        'select' => 'fields',
    ],

    'filters' => [
        'article' => [
            'no_comment' => 'No Comment',
            'not_solved' => 'Not Solved'
        ]
    ],
]

?>