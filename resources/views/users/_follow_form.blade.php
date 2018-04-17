@if(Auth::user()->id!=$user->id)
<div id="follow_form">
  @if(Auth::user()->isFollowing($user->id))
<form class="" action="{{route('followers.destroy',$user->id)}}" method="post">
  {{csrf_field()}}
  {{method_field('DELETE')}}
  <button type="submit" name="button" class="btn btn-sm">取消关注</button>
</form>
    @else
<form class="" action="{{route('followers.store',$user->id)}}" method="post">
  {{csrf_field()}}
  <button type="submit" name="button" class="btn btn-sm btm">关注</button>
</form>
  @endif
</div>
@endif
