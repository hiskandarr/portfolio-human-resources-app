<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (session('role') == 'HR') {
            $tasks = Task::all();
        } else {
            $tasks = Task::where('assigned_to', session('employee_id'))->get();
        }

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::all();

        return view('tasks.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'assigned_to' => 'nullable|string',
            'description' => 'required',
            'due_date' => 'required|date',
            'status' => 'required|string',
        ]);

        // Jika berhasil.
        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $employees = Employee::all();

        return view('tasks.edit', compact('task', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'assigned_to' => 'nullable|string',
            'description' => 'required',
            'due_date' => 'required|date',
            'status' => 'required|string',
        ]);

        // Jika berhasil validasi, maka update data.
        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete($task->id);

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    public function done(Task $task)
    {
        $task->status = 'done';
        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Task marked as done.');
    }

    public function pending(Task $task)
    {
        $task->status = 'pending';
        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Task marked as pending.');
    }
}
