<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Session;

class SessionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sessions')->insert([
            [
                'start_time' => '10:20:00',
                'end_time' => '12:30:00',
                'film_id' => 1,
                'hall_id' => 1
            ],
            [
                'start_time' => '14:10:00',
                'end_time' => '16:20:00',
                'film_id' => 1,
                'hall_id' => 1
            ],
            [
                'start_time' => '18:40:00',
                'end_time' => '20:50:00',
                'film_id' => 1,
                'hall_id' => 1
            ],
            [
                'start_time' => '14:40:00',
                'end_time' => '16:50:00',
                'film_id' => 1,
                'hall_id' => 2
            ],
            [
                'start_time' => '21:00:00',
                'end_time' => '23:10:00',
                'film_id' => 1,
                'hall_id' => 2
            ],
            // 
            [
                'start_time' => '17:00:00',
                'end_time' => '18:36:00',
                'film_id' => 2,
                'hall_id' => 1
            ],
            [
                'start_time' => '10:00:00',
                'end_time' => '11:36:00',
                'film_id' => 2,
                'hall_id' => 2
            ],
            [
                'start_time' => '12:00:00',
                'end_time' => '13:36:00',
                'film_id' => 2,
                'hall_id' => 2
            ],
        ]);
    }
}
