<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use Mail;
class UsersController extends Controller
{
    //创建用户页面
    public function create(){
      return view('users.create');
    }
    //根据ID显示用户信息
    public function show(User $user){
      $statuses = $user->statuses()
                      ->orderBy('created_at','desc')
                      ->paginate(10);
      return view('users.show',compact('user','statuses'));
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
      //Auth::login($user);
      //注册完成后，发送验证邮件到用户邮箱
      $this->sendEmailConfirmationTo($user);
      //消息(将消息加入到session中，flash是闪存，只仅下次访问生效，访问后立即删除)
      //session()->flash('success',"注册成功！开始您的非凡之旅吧~");
      session()->flash('success',"邮件发送成功，请登录到您注册的邮箱打开验证邮件进行验证！");
      //session()->flash('danger',"你的痛苦就是我的快乐~");

      //开启重定向，返回首页
      return redirect('/');
    }
    //发送邮箱认证的控制器动作
    public function sendEmailConfirmationTo($user){
      $view='emails.confirme';
      $data=compact('user');
      //$from='ruodee@126.com';
      //$name='ruodee';
      $to=$user->email;
      $subject="感谢注册sample，验证邮件已发送你邮箱，请打开邮箱查看邮件，点击链接进行验证。";
      //发送邮件，利用Mail组件
      //Mail::send('emails.confirm',$data,function($message) use ($from,$name,$to,$subject){
      Mail::send('emails.confirm',$data,function($message) use ($to,$subject){
        //$message->from($from,$name)->to($to)->subject($subject);
        $message->to($to)->subject($subject);
        //第一个参数是包含邮件消息的视图名称。第二个参数是要传递给该视图的数据数组。最后是一个用来接收邮件消息实例的闭包回调，我们可以在该回调中自定义邮件消息的发送者、接收者、邮件主题等信息。
      });
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
  //创建邮件验证的路由confirm_email对应的方法
  public function confirmEmail($token){
    $user = User::where('activation_token',$token)->firstOrFail();
    $user -> activated = true; //设置用户激活状态
    $user -> activation_token = null;//清空用户activaction_token信息，防止链接泄漏，绕过验证直接登录
    $user -> save();//用户模型保存到数据库
    //上面任务都完成，没有中断，则执行下面代码，登录用户
    Auth::login($user);
    session()->flash('success',"恭喜，验证成功！");
    return redirect()->route('users.show',[$user]);

  }
  //__cunstruct()使用UserController的初始化函数，为UserController控制器增加middleware
  public function __construct(){
    $this->middleware('auth',['except'=>['show','create','store','index','confirmEmail']]);
    $this->middleware('guest',['only' => 'create']);
  }
  //定义显示用户关注的方法，在except之外，默认是登陆后显示，安全的
  public function followings(User $user){
    $users=$user->followings()->paginate(10);
    $title="关注的人";
    return view('users.show_follow',compact('users','title'));
  }
  //定义显示用户粉丝的方法，在except之外，默认是安全的
  public function followers(User $user){
    $users=$user->followers()->paginate(10);
    $title="粉丝";
    return view('users.show_follow',compact('users','title'));
  }
}
