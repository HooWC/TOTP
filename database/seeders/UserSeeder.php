<?php

namespace Database\Seeders;

use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user1 = User::factory()
            ->create([
                'name' => 'fakeAccount011',
                'email' => 'fakeaccount@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('AccountPassword'), // 密码 AccountPassword
                'login_date' => now(),
                'is_disabled' => false,
            ]);

        $user2 = User::factory()
            ->create([
                'name' => 'fakeAdmin099',
                'email' => 'fakeadmin@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('AdminPassword'), // 密码 AdminPassword
                'login_date' => now(),
                'is_disabled' => false,
            ]);

        RoleUser::firstOrCreate([
            'user_id' => $user1->id,
            'role_id' => 1,
        ]);

        RoleUser::firstOrCreate([
            'user_id' => $user2->id,
            'role_id' => 2,
        ]);

        // 随机 创建 用户 5个
        $FakeUsers = User::factory()
            ->count(5)
            ->create();

        // 随机 设定Role
        $FakeUsers->each(function ($user) {
            RoleUser::firstOrCreate([
                'user_id' => $user->id,
                'role_id' => mt_rand(1, 2),
            ]);
        });
    }
}
