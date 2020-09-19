<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => "root",
                'login' => 'root',
                'phone' => '89511640057',
                'password' => Hash::make('123456'),
                'role' => 'механик',
                'access' => '1',
                'api_token' => Hash::make(\Str::random(17)),
            ],
            [
                'name' => "other",
                'login' => 'other',
                'phone' => '89511640057',
                'password' => Hash::make(\Str::random(17)),
                'role' => 'лифтер',
                'access' => '0',
                'api_token' => Hash::make(\Str::random(17)),
            ],
        ];

        DB::table('users')->insert($data);
    }
}
