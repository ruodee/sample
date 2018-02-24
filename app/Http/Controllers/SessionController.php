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
    session()->flash('success','登录成功，欢迎进入！');
    return redirect()->route('users.show',[Auth::user()]);
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
}
