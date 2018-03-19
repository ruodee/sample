<li>
  <img src="{{$user->gravatar()}}" alt="{{$user->name}}" class="gravatar">
  <a href="{{route('users.show',$user->id)}}" class="username">{{$user->name}}->id:{{$user->id}}</a>
  @can('destroy',$user)
  <form class="" action="{{ route('users.destroy',$user->id) }}" method="post">
    {{ csrf_field() }}
    {{ method_field('DELETE') }}
    <button type="submit"  class="btn btn-sm btn-danger delete-btn" name="button">删除</button>
  </form>
  @endcan
</li>
