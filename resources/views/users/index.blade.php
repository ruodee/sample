@extends('layouts.default')
@section('tityle','显示所有用户列表')
@section('content')
<div class="col-md-offset-2 col-md-8">
<h1>显示所有用户</h1>
  <ul class="users">
    @foreach($users as $user)
    @include('users._user')
    @endforeach
  </ul>
  {!! $users->render() !!}
</div>
@stop
