<?php

namespace App\Http\Controllers;

interface Cacheable
{
    public function cacheKeys();
}
