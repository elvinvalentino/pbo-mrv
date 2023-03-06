<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Http\Requests\Department\DepartmentRequest;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('departments/list', ['departments' => Department::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('departments/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentRequest $request)
    {
        $validated = $request->validated();

        Department::create([
            'name'    => $validated['name'],
        ]);

        return redirect()->route('departments.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        return view('departments/edit', ['department' => $department]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentRequest $request, Department $department)
    {
        $validated = $request->validated();

        $department->update([
            'name'      => $validated['name'],
        ]);

        return redirect()->route('departments.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index');
    }
}
