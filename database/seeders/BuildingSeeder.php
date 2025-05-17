<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BuildingSeeder extends Seeder
{
    public function run(): void
    {
        $buildings = ['AA', 'AB', 'AC', 'AD', 'AE'];

        foreach ($buildings as $suffix) {
            DB::table('Building')->insert([
                'name' => 'Build ' . $suffix,
                'location' => 'Polinema JTI',
                'status' => 'Good',
            ]);
        }
    }
}
