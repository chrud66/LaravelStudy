<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'account',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
        * 입력한 account 컬럼을 암호화
        * @param type $value 계좌 정보 컬럼
    */
    public function setAccountAttribute($value)
    {
        $this->attributes['account'] = \Crypt::encrypt($value);
    }
    /**
        * 암호화된 account 컬럼을 복호화
        * @param type $value 암호화된 컬럼
        * @return type 복호화된 컬럼
    */
    public function getAccountAttribute($value)
    {
        return \Crypt::decrypt($value);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function tasks()
    {
        return $this->hasManyThrough(Task::class, Project::class);
    }

    public function pictures()
    {
        return $this->morphMany(Picture::class, 'imageable');
    }
}
