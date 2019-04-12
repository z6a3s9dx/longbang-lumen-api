<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaultUser = DB::table('users')->where('account', 'thothadmin')->first();
        if ($defaultUser === null) {
            DB::table('users')->insert([
                'account'    => 'thothadmin',
                'password'   => Hash::make('password'),
                'name'       => '圖特人員',
                'active'     => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }
    }
}
