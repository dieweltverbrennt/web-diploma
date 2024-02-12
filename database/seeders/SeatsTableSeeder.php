<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Seat;
use App\Models\Hall;

class SeatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $halls = \App\Models\Hall::all();

        foreach ($halls as $hall) {
            foreach (range(1, $hall->rows_count) as $row) {
                foreach (range(1, $hall->seats_in_row_count) as $seatInRow) {
                    $type = $this->getRandomSeatType($row, $seatInRow);
                    $price = $this->getSeatPrice($type);
        
                    Seat::factory()->create([
                        'hall_id' => $hall->id,
                        'row_number' => $row,
                        'seat_number' => $seatInRow,
                        'type' => $type,
                        'is_free' => true,
                        'price' => $price
                    ]);
                }
            }
        }

    }

    protected function getRandomSeatType($row, $seatInRow) {
        // Определение типа в зависимости от условий
        if ($row == 1 && ($seatInRow < 6 || $seatInRow > 7)) {
            return 'disabled';
        } elseif ($row == 2 && ($seatInRow < 5 || $seatInRow > 8)) {
            return 'disabled';
        } elseif ($row == 3 && ($seatInRow < 2 || $seatInRow > 9)) {
            return 'disabled';
        } elseif ($row == 4 && ($seatInRow > 5 && $seatInRow < 8)) {
            return 'vip';
        } elseif (($row > 3 && $row < 9) && $seatInRow > 9) {
            return 'disabled';
        } elseif (($row > 4 && $row < 8) && ($seatInRow > 4 && $seatInRow < 9)) {
            return 'vip';
        }
        return 'standart';
    }

    protected function getSeatPrice($type) {
        // Определение цены в зависимости от типа места
        switch ($type) {
            case 'vip':
                return 350;
            case 'standart':
                return 250;
            case 'disabled':
                return 0; 
            default:
                return 0;
        }
    }
}
