<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Status;
use Illuminate\Auth\Access\HandlesAuthorization;

class StatusPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
     //定义一个删除策略，用户只能删除自己创建发布的微博：statuses;
     public function destroy(User $user,Status $status){
       return $status->user_id == $user->id;
     }
    public function __construct()
    {
        //
    }
}
