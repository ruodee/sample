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
    //编辑用户信息
    public function edit(User $user){
      $this->authorize('update',$user);
      return view('users.edit',compact('user'));
    }
  //更新用户方法
  public function update(User $user,Request $request)
  {
    //验证
    $this->validate($request,[
      'name'=>"required|max:50",
      'password'=>"nullable|confirmed|min:6",
    ]);
    //验证过后的处理部分
    $this->authorize('update',$user);
    $data=[];
    $data['name']=$request->name;
    if($request->password)
    $data['password']=$request->password;
    $user->update($data);
    session()->flash('success','用户信息修改成功！');
    return redirect()->route('users.show',$user->id);
  }
  //删除界面和功能
  public function  destroy(User $user){
    $this -> authorize('destroy',$user);
    $user -> delete();
    session() -> flash('success','删除用户成功！');
    return back();
  }

  //index函数，列出所有用户
  public function index(){
    $users=User::paginate(4);
    return view('users.index',compact('users'));
  }
  //__cunstruct()使用UserController的初始化函数，为UserController控制器增加middleware
  public function __construct(){
    $this->middleware('auth',['except'=>['show','create','store','index']]);
    $this->middleware('guest',['only' => 'create']);
  }
}
