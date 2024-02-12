<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Session;
use App\Models\Hall;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sessions = Session::with('hall', 'film')->get();
        return response()->json(['sessions' => $sessions]);
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
        $request->validate([
            'sessions' => 'required|array',
            'sessions.*' => 'required'
        ]);
        $sessions = $request->sessions;
        try {
            foreach($sessions as $session) {
                Session::create([
                    'start_time' => Carbon::createFromTimeString($session['start']),
                    'end_time' => Carbon::createFromTimeString($session['end']),
                    'film_id' => $session['filmId'],
                    'hall_id' => $session['hallId'],
                ]);
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
        $session = Session::with(['hall.seats', 'film'])->findOrFail($id);
        return response()->json(['session' => $session]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $ids)
    {
        $sessionIds = explode(',', $ids);
        try {
            $session = Session::whereIn('id', $sessionIds)->get();
            Session::whereIn('id', $sessionIds)->delete();

            $halls = Hall::with('sessions.film', 'seats')->get();
            return response()->json(['halls' => $halls], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 201);
        }
    }
}
