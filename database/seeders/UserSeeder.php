<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            'user' => 'user@user.com',
            'customer' => 'customer@user.com',
            'client' => 'client@client.com',
        ];
        foreach ($users as $key => $value) {
            $user = User::create([
                'name' => $key,
                'email' => $value,
                'password' => Hash::make('password'),
            ]);
        }
    }
}
