@extends('layouts.default')
@section('title','home')
@section('content')
<div class="jumbotron">
    <h1>Hello Laravel</h1>
    <p class="lead">
      你现在所看到的是 <a href="https://laravel-china.org/courses/laravel-essential-training-5.1">Laravel 入门教程</a> 的示例项目主页。
    </p>
    <p>
      一切，将从这里开始。
    </p>
    <p>
      @if(!Auth::check())
      <a class="btn btn-lg btn-success" href="{{route('users.create')}}" role="button">现在注册</a>
      @endif
    </p>
  </div>
  @stop
