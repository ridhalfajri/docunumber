<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $lastId = DB::table('sk_numbers')->max('id');
            $newId = $lastId ? $lastId + 1 : 1;
            $sk_number = "{$newId}/KEP/BSN/1/2025";
            DB::table('sk_numbers')->insert([
                'sk_number' => $sk_number, // Menambahkan nomor SK
                'date' => Carbon::now(), // Menambahkan tanggal acak
                'is_verified' => 0, // Status verifikasi acak
                'created_at' => Carbon::now(), // Waktu pembuatan
                'updated_at' => Carbon::now(), // Waktu pembaruan
            ]);
        }
    }
}
