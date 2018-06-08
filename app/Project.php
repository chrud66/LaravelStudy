<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function tasks()
    {
        //return $this->hasOne(Task::class);
        //return $this->hasMany(Task::class);
        return $this->hasMany('App\Task');
    }

    //연관 모델 삭제하기 3가지 방법중 하나
    protected static function boot()
    {
        parent::boot();

        //delete() 수행전 호출
        static::deleting(function ($project) {
            $project->tasks()->delete();
        });
    }
}
