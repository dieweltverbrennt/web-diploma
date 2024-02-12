<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hall;
use App\Models\Seat;

class HallController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $halls = Hall::with('sessions.film', 'seats')->get();
        return response()->json(['halls' => $halls]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $hallNumber = $request->hall_number ? $request->hall_number : intval(Hall::max('hall_number')) + 1;
            $rowsCount = $request->rows_count ? $request->rows_count : 10;
            $seatsInRowCount = $request->seats_in_row_count ? $request->seats_in_row_count : 10;
            $seatCount = $rowsCount * $seatsInRowCount;

            $hall = Hall::create([
                'hall_number' => $hallNumber,
                'rows_count' => $rowsCount,
                'seats_in_row_count' => $seatsInRowCount,
                'seat_count' => $seatCount,
                'is_active' => false
            ]);

            for ($row = 1; $row <= $rowsCount; $row++) {
                for ($seatNumber = 1; $seatNumber <= $seatsInRowCount; $seatNumber++) {
                    Seat::create([
                        'row_number' => $row,
                        'seat_number' => $seatNumber,
                        'hall_id' => $hall->id,
                        'type' => 'standart',
                        'is_free' => true,
                        'price' => 0,
                    ]);
                }
            }

            $halls = Hall::with('sessions.film', 'seats')->get();

            return response()->json(['halls' => $halls], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $hall = Hall::findOrFail($id);
        return response()->json(['hall' => $hall]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $request->validate([
        //     'rows' => 'required|integer',
        //     'seats' => 'required|integer',
        // ]);
        if($request->rows && $request->seats) {
            $total_number = $request->rows * $request->seats;

            $hallModel = Hall::findOrFail($id);
            $hallModel->update(['rows_count' => $request->rows, 'seats_in_row_count' => $request->seats, 'seat_count' => $total_number]);

            $halls = Hall::with('sessions', 'seats')->get();

            return response()->json(['halls' => $halls]);
        } else {
            $ids = explode(',', $id);
            $hallModels = Hall::findOrFail($ids);
            foreach($hallModels as $hallModel) {
                $hallModel->update(['is_active' => $request->isActive]);
            }

            $halls = Hall::with('sessions.film', 'seats')->get();
            return response()->json(['halls' => $halls]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Находим зал по его идентификатору
            $hall = Hall::findOrFail($id);
            // Удаляем зал из базы данных
            $hall->delete();
            // Возвращаем успешный ответ
            $halls = Hall::with('sessions.film')->get();
            return response()->json(['halls' => $halls], 201);
        } catch (\Exception $e) {
            // Если произошла ошибка, возвращаем сообщение об ошибке
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
