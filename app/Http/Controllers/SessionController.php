<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class SessionController extends Controller
{
    //route get Login
public function create(){
  return view('sessions.create');
}
//route post login 认证 登录认证
public function store(Request $request){
  $credentials = $this->validate($request,[
    'email'=>'required|email|max:255',
    'password'=>'required'
  ]);
  if(Auth::attempt($credentials,$request->has('remember')))
  {
    //验证用户是否已经激活
    if(Auth::user()->activated)
    {
    session()->flash('success','登录成功，欢迎进入！');
    return redirect()->intended(route('users.show',[Auth::user()]));
    }
    else {
      Auth::logout();
      session()->flash('warning',"你的帐号未进行邮件激活验证，请前往注册邮箱进行激活！");
      return redirect('/');
    }
  }
    else {
      session()->flash('danger','用户名不存在或密码错误！');
      return redirect()->back()->withinput();
    }
}
//退出登录的操作
public function destroy(){
  Auth::logout();
  session()->flash('success','退出成功，欢迎再次登录！');
  return redirect('login');
}
//设置过滤机制
public function __construct(){
  $this->middleware('guest',['only'=>'create']);
}
}
