<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\MstUser;

class MstUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // テストユーザー1
        MstUser::create([
            'name' => 'テストユーザー',
            'login_id' => 'test001',
            'email' => 'test001@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
