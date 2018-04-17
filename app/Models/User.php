<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //创建用户头像的gravatar
    public function gravatar($size='100'){
      $hash = md5(strtolower(trim($this->attributes['email'])));
      return "http://www.gravatar.com/avatar/$hash?s=$size";
    }
    //创建模型监听
    //boot 方法会在用户模型类完成初始化之后进行加载，因此我们对事件的监听需要放在该方法中。
    public static function boot(){
      parent::boot();
      static::creating(function($user){
        $user->activation_token = str_random(30);
      });
    }
    //USER模型定义一个密码重置发送邮件的USER模型功能
    public function sendPasswordResetNotification($token){
      $this->notify(new ResetPassword($token));
    }
    //定义与微博status模型的关联，因为一个用户可以有多条微博，是一对多关系，因而定义函数名为复数
    public function statuses(){
      return $this->hasMany(Status::class);
    }
    //定义一个获取用户更新动态的所有内容，并按发布时间倒序排序
    public function feed(){
      $user_ids = Auth::user()->followings->pluck('id')->toArray();
      array_push($user_ids,Auth::user()->id);
      return Status::whereIn('user_id',$user_ids)->with('user')->orderBy('created_at','desc');
    }
    //定义粉丝的模型关联，多对多关联，自定义中间表，即获取一个用户的粉丝
    public function followers(){
      return $this->belongsToMany(User::class,'followers','user_id','follower_id');
    }
    //定义关注者的模型关联,即一个用户关注的人
    public function followings(){
      return $this->belongsToMany(User::class,'followers','follower_id','user_id');
    }
    //定义一个关注动作
    public function follow($user_ids){
      //如果不是数组，则变为数组
      if(!is_array($user_ids))
      $user_ids=compact('user_ids');
      $this->followings()->sync($user_ids,false);

    }
    //取消关注
    public function unfollow($user_ids){
      if(!is_array($user_ids))
      $user_ids=compact('user_ids');
      $this->followings()->detach($user_ids);
    }
    //判断当前用户是否关注了另外一个用户
    public function isFollowing($user_id){
      return $this->followings->contains($user_id);
    }
}
