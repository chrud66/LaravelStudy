<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $cache;

    public function __construct()
    {
        if ((new \ReflectionClass($this))->implementsInterface(\App\Http\Controllers\Cacheable::class) and taggable()) {
            $this->cache = app('cache')->tags($this->cacheKeys());
        }
    }

    public function etags($collection, $cacheKey = null)
    {
        $etag = '';

        foreach($collection as $instance) {
            $etag .= $instance->etag();
        }

        return md5($etag.$cacheKey);
    }

    protected function cache($key, $minutes, $query, $method, ...$args)
    {
        $args = (! empty($args)) ? implode(',', $args) : null;

        if (config('project.cache') === false)  {
            return $query->{$method}($args);
        }

        return $this->cache->remember($key, $minutes, function () use ($query, $method, $args) {
            return $query->{$method}($args);
        });
    }

    /**
     * Do the filter, search, and sorting job
     *
     * @param $query
     * @return mixed
     */
    protected function filter($query)
    {
        $params = config('project.params');

        if ($filter = request()->input($params['filter'])) {
            $query = $query->{camel_case($filter)}();
        }

        if ($keyword = request()->input($params['search'])) {
            $raw = 'MATCH(title,content) AGAINST(? IN BOOLEAN MODE)';
            $query = $query->whereRaw($raw, [$keyword]);
        }

        $sort = request()->input($params['sort'], 'created_at');
        $direction = request()->input($params['order'], 'desc');

        if ($sort == 'created') {
            // We transformed field name of 'created_at' to 'created'.
            // Applicable only to api request. But this code laid here
            // to suppress QueryException of not existing column in web request.
            $sort = 'created_at';
        }

        return $query->orderBy($sort, $direction);
    }
}
