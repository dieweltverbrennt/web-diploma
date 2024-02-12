<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $films = Film::with('sessions.hall')->get();
        return response()->json(['films' => $films]);
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
            'film' => 'required|array',
            'film.*' => 'required'
        ]);

        $film = $request->film;

        Film::create([
            'name' => $film['name'],
            'description' => $film['description'],
            'production_country' => $film['productionCountry'],
            'duration' => $film['duration'],
            'path_to_image' => $film['poster']
        ]);

        $films = Film::with('sessions.hall')->get();
        return response()->json(['films' => $films]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
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
    public function destroy(string $id)
    {
        //
    }
}
