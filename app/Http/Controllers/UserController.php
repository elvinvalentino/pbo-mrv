<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Position;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return view('users/list', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users/create', ['departments' => Department::all(), 'positions' => Position::orderBy('level')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        DB::transaction(function() use ($validated) {

            $department = Department::findOrFail($validated['department_id']);
            $user = User::create([
                'username'          => $validated['username'],
                'name'              => $validated['name'],
                'role'              => $validated['role'],
                'department_id'     => $department->id,
                'password'          => Hash::make($validated['password']),
                'is_active'         => $validated['status'] == '1' ? true : false,
            ]);

            foreach($validated['position_ids'] as $position_id) {
                $position = Position::findOrFail($position_id);
                $user->positions()->attach($position->id);
            }
        });


        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $selectedPositions = $user->positions()->get()->toArray();
        $selectedPositionIds = array_map(function($selectedPosition) {
            return $selectedPosition['id'];
        }, $selectedPositions);


        return view('users/edit', [
            'user' => $user, 
            'departments' => Department::all(), 
            'positions' => Position::orderBy('level')->get(), 
            'selectedPositionIds' => $selectedPositionIds
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();

        DB::transaction(function() use ($validated, $user) {

            $department = Department::findOrFail($validated['department_id']);
            $user->update([
                'username'          => $validated['username'],
                'name'              => $validated['name'],
                'role'              => $validated['role'],
                'department_id'     => $department->id,
                'password'          => Hash::make($validated['password']),
                'is_active'         => $validated['status'] == '1' ? true : false,
            ]);

            $positions = $user->positions()->get();
            foreach ($positions as $position) {
                $user->positions()->detach($position->id);
            }

            foreach($validated['position_ids'] as $position_id) {
                $position = Position::findOrFail($position_id);
                $user->positions()->attach($position->id);
            }
        });

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index');
    }
}
