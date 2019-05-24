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
                'created_at' => '2018-05-01 00:00:00',//\Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }
        $defaultUser = DB::table('users')->where('account', 'thothtest')->first();
        if ($defaultUser === null) {
            DB::table('users')->insert([
                'account'    => 'thothtest',
                'password'   => Hash::make('password'),
                'name'       => '圖特test',
                'active'     => 2,
                'created_at' => '2018-05-02 00:00:00',//\Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }
    }
}
