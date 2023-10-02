<?php

namespace Database\Seeders;

use App\Http\Controllers\AccountContorller;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            'username' => "___mohit06",
            "email" => "dev.mohit2006@gmail.com",
            "password" => bcrypt("@Mohit123"),
            "profile_picture" => "deafult.jpg",
            "role" => 1,
            "account_status" => 1,
            "subscription_status" => 0,
            "verification_token" => AccountContorller::getVerificationToken(),
        ];

        User::factory()->create($user);
    }
}
