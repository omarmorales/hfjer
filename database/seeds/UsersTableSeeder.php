<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Omar Morales',
                'email' => 'saul090594@gmail.com',
                'password' => bcrypt('password'),
                'type' => 'admin',
                'organization_id' => 1,
                'active' => 0,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Saul Morales',
                'email' => 'omorales@c-230.com',
                'password' => bcrypt('password'),
                'type' => 'author',
                'organization_id' => 1,
                'active' => 0,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ];

        DB::table('users')->insert($users);
    }
}
