<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
  //添加可填充字段
protected $fillable = ['content'];
    //模型关联，一个status只属于一个用户的
    public function user(){
      return $this->belongsTo('App\Models\User');
    }
}
