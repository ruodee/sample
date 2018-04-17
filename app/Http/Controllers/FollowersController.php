<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\requests;
use App\Models\User;
use Auth;

class FollowersController extends Controller
{
  //初始化
  public function construct(){
    $this->middleware('auth');//增加Auth中间件过滤，职能由登录的用户才能i
  }
    //关注
    public function store(User $user){
      if(Auth::user()->id===$user->id)return direct('/');//防止直接访问，绕过视图，视图上不显示和控制器不能使用是两个概念
      if(!Auth::user()->isFollowing($user))Auth::user()->follow($user->id);//如果用户没关注，则进行关注
      return redirect()->route('users.show',$user->id);//返回用户信息显示
    }
    //取消关注
    public function destroy(User $user){
      if(Auth::user()->id === $user->id )return redirect('/');
      if(Auth::user()->isFollowing($user->id ))
    {
      Auth::user()->unfollow($user->id);
    }
    return redirect()->route('users.show',$user->id);
    }
}
