<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Presence;
use Illuminate\Http\Request;

class PresenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $presences = Presence::all();

        return view('presences.index', compact('presences'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::all();

        return view('presences.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'check_in' => 'required|date',
            'check_out' => 'nullable|date|after:check_in',
            'date' => 'required|date',
            'status' => 'required|string|max:255',
        ]);

        Presence::create($request->all());

        return redirect()->route('presences.index')->with('success', 'Presence recorded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Presence $presence)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Presence $presence)
    {
        $employees = Employee::all();

        return view('presences.edit', compact('presence', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Presence $presence)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'check_in' => 'required|date',
            'check_out' => 'nullable|date|after:check_in',
            'date' => 'required|date',
            'status' => 'required|string|max:255',
        ]);

        $presence->update($request->all());

        return redirect()->route('presences.index')->with('success', 'Presence updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Presence $presence)
    {
        //
    }
}
