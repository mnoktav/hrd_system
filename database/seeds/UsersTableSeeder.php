<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $uuid = Str::uuid()->toString();
        User::create([
            'uuid' => $uuid,
            'first_name' => 'Giant',
            'email' => 'giant@gmail.com',
            'password' => Hash::make('helpplease')
        ]);
    }
}
