<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        $facilities = [
            ['name' => 'Projector', 'type' => 'Electronic'],
            ['name' => 'Whiteboard', 'type' => 'Miscellaneous'],
            ['name' => 'Computer Monitor', 'type' => 'Computer'],
            ['name' => 'System Unit', 'type' => 'Computer'],
            ['name' => 'Mouse', 'type' => 'Electronic'],
            ['name' => 'Keyboard', 'type' => 'Electronic'],
            ['name' => 'Printer', 'type' => 'Electronic'],
            ['name' => 'Lab Chair', 'type' => 'Chair'],
            ['name' => 'Lab Table', 'type' => 'Table'],
            ['name' => 'Instructor Desk', 'type' => 'Desk'],
        ];

        $buildingIDs = DB::table('Building')->pluck('building_ID');

        foreach ($buildingIDs as $buildingID) {
            foreach ($facilities as $facility) {
                DB::table('Facility')->insert([
                    'name' => $facility['name'],
                    'type' => $facility['type'],
                    'building_ID' => $buildingID,
                    'status' => 'Good',
                ]);
            }
        }
    }
}
