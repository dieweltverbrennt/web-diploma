<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seat;

class SeatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $seats = $request->seats;
        foreach($seats as $seat) {
            Seat::create([
                'row_number' => $seat['row_number'],
                'seat_number' => $seat['seat_number'],
                'hall_id' => $seat['hall_id'],
                'type' => $seat['type'],
                'is_free' => true,
                'price' => 0,
            ]);
        }
        return response()->json(['seats' => $seats]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $ids)
    {
        $seatIds = explode(',', $ids);
        try {
            $seats = Seat::whereIn('id', $seatIds)->get();
            return response()->json(['seats' => $seats]);
        } 
        catch (\Exception $e) {
            return response()->json(['success' => false]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Array $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $ids)
    {
        try {
            $seatIds = explode(',', $ids);

            if($request->seats) {
                $seats = $request->seats;

                foreach ($seats as $seat) {
                    $seatModel = Seat::findOrFail($seat['id']);
                    $seatModel->update(['type' => $seat['type']]);
                }
                return response()->json(['request' => $seats]);
            } elseif($request->hall && $request->price && $request->type) {

                $seatModel = Seat::where('hall_id', $request->hall)
                ->where('type', $request->type)
                ->update(['price' => $request->price]);
                return response()->json(['success' => true]);
            } else {
                foreach ($seatIds as $seatId) {
                    $seatModel = Seat::findOrFail($seatId);
                    $seatModel->update(['is_free' => !$seatModel->is_free]);
                }
                return response()->json(['success' => true, 'message' => 'Статусы мест успешно изменены']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Не удалось изменить статусы мест']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $ids)
    {
        $seatIds = explode(',', $ids);
        try {
            $seats = Seat::whereIn('id', $seatIds)->get();
            Seat::whereIn('id', $seatIds)->delete();
        
            $allSeats = Seat::all();
            return response()->json(['seats' => $allSeats]);
        } 
        catch (\Exception $e) {
            return response()->json(['success' => false]);
        }
    }
}
