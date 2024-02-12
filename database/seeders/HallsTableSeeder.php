<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Hall;

class HallsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('halls')->insert([
            [
                'hall_number' => 1,
                'seat_count' => 120,
                'rows_count' => 10,
                'seats_in_row_count' => 12,
                'is_active' => true
            ],
            [
                'hall_number' => 2,
                'seat_count' => 120,
                'rows_count' => 10,
                'seats_in_row_count' => 12,
                'is_active' => true
            ],
        ]);
    }
}
