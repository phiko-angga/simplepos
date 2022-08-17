<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('barang')->insert([
            'nama' => 'Minyak goreng Fortune 2KG', 
            'deskripsi' => 'Minyak goreng', 
            'harga_beli' => 13000,
            'harga_jual' => 16000,
        ],[
            'nama' => 'Beras SB 10KG', 
            'deskripsi' => 'Beras', 
            'harga_beli' => 90000,
            'harga_jual' => 120000,
        ],[
            'nama' => 'Gulaku 2KG', 
            'deskripsi' => 'Gula', 
            'harga_beli' => 22000,
            'harga_jual' => 25000,
        ],[
            'nama' => 'Indomie Goreng', 
            'deskripsi' => 'Mie Instan', 
            'harga_beli' => 2500,
            'harga_jual' => 3000,
        ],[
            'nama' => 'Masako Rasa Sapi 1 renteng', 
            'deskripsi' => 'Bumbu Masako', 
            'harga_beli' => 10000,
            'harga_jual' => 13000,
        ],[
            'nama' => 'Tepung Segitiga Biru', 
            'deskripsi' => 'Tepung terigu', 
            'harga_beli' => 14000,
            'harga_jual' => 17000,
        ]);
    }
}
