<?php

if (!function_exists('markdown')) {
    function markdown($text)
    {
        //return app(ParsedownExtra::class)->text($text);
        return app(App\Services\Markdown::class)->text($text);
    };
};

if (!function_exists('icon')) {
    function icon($class, $addition = 'icon', $inline = null)
    {
        $icon = config('icons.' . $class);
        $inline = $inline ? 'style="' . $inline . '"' : null;

        return sprintf('<i class="%s %s" %s></i>', $icon, $addition, $inline);
    };
};

if (!function_exists('attachment_path')) {
    function attachment_path($path = '')
    {
        return public_path($path ? 'attachments' . DIRECTORY_SEPARATOR . $path : 'attachments');
    };
};

if (!function_exists('gravatar_profile_url')) {
    function gravatar_profile_url($email)
    {
        return sprintf("//www.gravatar.com/%s", md5($email));
    };
};

if (!function_exists('gravatar_url')) {
    function gravatar_url($email, $size = 72)
    {
        return sprintf("//www.gravatar.com/avatar/%s?s=%s", md5($email), $size);
    };
};

if (! function_exists('is_api_request')) {
    /**
     * Determine if the current request is for HTTP api.
     *
     * @return bool
     */
    function is_api_request()
    {
        return starts_with(request()->getHttpHost(), env('API_DOMAIN'));
    }
}

if (! function_exists('optimus')) {
    function optimus($id = null)
    {
        $factory = app(\Jenssegers\Optimus\Optimus::class);

        if (func_num_args() === 0) {
            return $factory;
        }

        return $factory->encode($id);
    }
}

if (!function_exists('link_for_sort')) {
    function link_for_sort($column, $text, $params = [])
    {
        // 현재 요청의 'd' 쿼리 파라미터가 asc 이면, $reverse 에 desc
        $direction = Request::input('d');
        $reverse = $direction == 'asc' ? 'desc' : 'asc';

        // 정렬을 위한 쿼리 파라미터(s) 의 값이 있으면,
        // 오름차순 또는 내림차순 아이콘을 함수의 인자로 넘겨 받은 $text 에 붙인다.
        if (Request::input('s') == $column) {
            $text = sprintf(
                "%s %s",
                $direction == 'asc' ? icon('asc') : icon('desc'),
                $text
            );
        };

        // 현재 요청의 쿼리 스트링에서 'page', 's', 'd' 등을 제외한 나머지 쿼리 스트링과
        // 이 함수의 인자로 넘겨 받은 값들로 생성한 's', 'd' 등의 쿼리 스트링을 합쳐서
        // Anchor 태그의 href 속성 값에서 사용할 $queryString 생성한다.
        $queryString = http_build_query(array_merge(
            Input::except(['page', 's', 'd']),
            ['s' => $column, 'd' => $reverse],
            $params
        ));

        // 현재 요청 URL 을 Request::url() 로 얻어 오고,
        // 앞에서 만든 $queryString 문자열을 합쳐서 완전한 HTML <a> 태그를 생성한다.
        return sprintf(
            '<a href="%s?%s">%s</a>',
            urldecode(Request::url()),
            $queryString,
            $text
        );
    };
}

if (! function_exists('taggable')) {
    function taggable()
    {
        return !in_array(config('cache.default'), ['file', 'database']);
    };
};

if (! function_exists('cache_key')) {
    /**
     * Generate key for caching.
     *
     * Note. Even though the request endpoints are the same,
     *       the response body should be different because of the query string.
     *
     * @param $base
     * @return string
     */
    function cache_key($base)
    {
        $key = ($uri = request()->fullUrl())
            ? $base . '.' . urlencode($uri)
            : $base;

        return md5($key);
    }
}
