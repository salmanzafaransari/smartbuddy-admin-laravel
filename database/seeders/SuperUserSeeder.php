<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       User::updateOrCreate(
            ['email' => 'admin@smartbuddy.in'], // super user email
            [
                'first_name'        => 'Super',
                'last_name'         => 'Admin',
                'profile_photo'     => 'assets/images/user-avatar.jpg',
                'password'          => Hash::make('SmartBuddyPassword@123'),
                'is_superuser'      => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
