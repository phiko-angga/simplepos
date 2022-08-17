<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'superadmin', 
            'password' => Hash::make('superadmin'), 
            'email' => 'superadmin@gmail.com',
            'level_id' => '1',
        ]);
        DB::table('users')->insert([
            'name' => 'kasir', 
            'password' => Hash::make('kasir'), 
            'email' => 'kasir@gmail.com',
            'level_id' => '2',
        ]);
    }
}
