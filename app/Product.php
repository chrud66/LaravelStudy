<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function pictures()
    {
        return $this->morphMany(Picture::class, 'imageable');
    }
}
