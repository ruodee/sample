<?php

namespace App\Http\Controllers;
use  Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
class UsersController extends Controller
{
    //创建用户页面
    public function create(){
      return view('users.create');
    }
    //根据ID显示用户信息
    public function show(User $user){
      return view('users.show',compact('user'));
    }
    //接收POST过来的用户表单数据
    public function store(Request $request)
    {
      $this->validate($request,[
        'name'=>'required|max:50',
        'email'=>'required|email|unique:users|max:255',
        'password'=>'required|confirmed|min:6'
      ]);
      //验证成功过后，创建一个新用户。！如果验证不成功在上面代码就会抛出错误，以下代码不会执行
      $user = User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>bcrypt($request->password)
      ]);
      //注册完成后自动登录新注册用户
      Auth::login($user);
      //消息(将消息加入到session中，flash是闪存，只仅下次访问生效，访问后立即删除)
      session()->flash('success',"注册成功！开始您的非凡之旅吧~");
      session()->flash('danger',"你的痛苦就是我的快乐~");

      //开启重定向，并将数据绑定到路由
      return redirect()->route('users.show',[$user]);
    }
    
}
