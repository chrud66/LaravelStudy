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

    /**
     * 쿼리 스코프 추가
     * 완료 기한이 7일 이내인 할 일만 조회
     *
     * @return \Illuminate\Database\Eloquent\builder
    */
    public function scopeDueIn7Days($query)
    {
        return $query->where('due_date', '>', \Carbon\Carbon::now()->subDays(7));
    }

    /**
     * 쿼리 스코프 추가
     * 완료 기한이 days 이내인 할 일만 조회
     *
     * @return \Illuminate\Database\Eloquent\builder
    */
    public function scopeDueInDays($query, $days)
    {
        //return $query->where('due_date', '>', \Carbon\Carbon::now()->subDays(7));
        return $query->where('due_date', '>', \Carbon\Carbon::now()->subDays($days));
    }
}
