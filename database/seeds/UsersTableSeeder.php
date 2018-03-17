<?php

use Illuminate\Database\Seeder;
use App\Models\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class)->times(50)->make();
        User::insert($users->makeVisible(['password','remember_token'])->toArray());
        //设置一个固定的管理员账户
        $user = User::find(1);
        $user -> name = '管理员';
        $user -> email = 'admin@admin.com';
        $user -> password = bcrypt('admin');//密码是：admin
        $user -> is_admin = true;
        $user -> save();
    }
}
