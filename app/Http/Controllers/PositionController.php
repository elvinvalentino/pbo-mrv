<?php

namespace App\Http\Controllers;

use App\Http\Requests\Position\PositionRequest;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('positions/list', ['positions' => Position::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('positions/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PositionRequest $request)
    {
        $validated = $request->validated();

        Position::create([
            'level'    => $validated['level'],
        ]);

        return redirect()->route('positions.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Position $position)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Position $position)
    {
        return view('positions/edit', ['position' => $position]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PositionRequest $request, Position $position)
    {
        $validated = $request->validated();

        $position->update([
            'level'      => $validated['level'],
        ]);

        return redirect()->route('positions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Position $position)
    {
        $position->delete();
        return redirect()->route('positions.index');
    }
}
