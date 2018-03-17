<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;
    //用户更新策略
  public function update(User $currentUser, User $user)
  {
    return  $currentUser->id === $user->id;
  }
 //用户删除策略
 public function destroy(User $currentUser, User $user){
   return $currentUser -> is_admin && $currentUser -> id !== $user -> id;
 }
    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
}
