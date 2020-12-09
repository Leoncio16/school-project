<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Roles;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = new User();
        $user->name = 'user2';
        $user->email = 'user2@example.com';
        $user->password = Hash::make('user');
        $user->save();
        $user->roles()->attach(3);
    }
}
