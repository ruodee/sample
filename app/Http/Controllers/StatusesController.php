<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Status;
use Auth;
class StatusesController extends Controller
{
  // //定义可填充字段,在模型中定义，Status
  //   protected $fillable = ['content'];
  //   //使用中间件过滤
    public function __construct(){
      $this->middleware('auth');
    }
    //定义创建微博的动作
    public function store(Request $request){
        $this->validate($request,[
          'content' => 'required|max:140'
        ]);
        Auth::user()->statuses()->create(['content'=>$request['content']]);
        return redirect()->back();
    }
    //定义删除微博的动作
    public function destroy(Status $status){
$this->authorize('destroy',$status);
$status->delete();
session()->flash('success',"id为".$status->id."的微博已删除！");
return redirect()->back();
    }
}
