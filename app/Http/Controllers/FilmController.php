<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        $image = $request->file('poster');
        $path = $image->store('public/posters');
        $imageUrl = asset('storage/' . $path);
        $cleanPath = str_replace('public/', '', $imageUrl);

        Film::create([
            'name' => $request->name,
            'description' => $request->description,
            'production_country' => $request->productionCountry,
            'duration' => $request->duration,
            'path_to_image' => $cleanPath
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
