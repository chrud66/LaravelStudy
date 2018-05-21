<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    //화이트 리스트 방식
    //protected $fillable = ['name', 'project_id', 'description'];
    protected $fillable = ['name', 'project_id'];

    //블랙 리스트 방식
    //protected $guarded = ['description'];
}
