<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    public function imageable()
    {
        return $this->morphTo();
    }
}
