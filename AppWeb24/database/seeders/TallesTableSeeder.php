<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TallesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('talles')->insert([
            ['Talle' => 'S', 'Ancho' => 50, 'Altura' => 67],
            ['Talle' => 'M', 'Ancho' => 53, 'Altura' => 72],
            ['Talle' => 'L', 'Ancho' => 55, 'Altura' => 74],
            ['Talle' => 'XL', 'Ancho' => 58, 'Altura' => 76],
            ['Talle' => 'XXL', 'Ancho' => 61, 'Altura' => 79],
            ['Talle' => 'XXXL', 'Ancho' => 63, 'Altura' => 81],
        ]);
    }
}
