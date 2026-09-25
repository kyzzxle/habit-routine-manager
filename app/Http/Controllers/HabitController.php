<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use Illuminate\Http\Request;

class HabitController extends Controller
{
    public function index()
    {
        $habits = Habit::latest()->get();
        return view('habits.index', compact('habits'));
    }

    public function create()
    {
        return view('habits.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'habit_name'  => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:Pending,Completed',
            'due_date'    => 'nullable|date',
        ]);

        Habit::create($validated);

        return redirect()->route('habits.index')->with('success', 'Habit added!');
    }

    public function show(string $id)
    {
        return redirect()->route('habits.index');
    }

    public function edit(string $id)
    {
        $habit = Habit::findOrFail($id);
        return view('habits.edit', compact('habit'));
    }

    public function update(Request $request, string $id)
    {
        $habit = Habit::findOrFail($id);

        $validated = $request->validate([
            'habit_name'  => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:Pending,Completed',
            'due_date'    => 'nullable|date',
        ]);

        $habit->update($validated);

        return redirect()->route('habits.index')->with('success', 'Habit updated!');
    }

    public function destroy(string $id)
    {
        $habit = Habit::findOrFail($id);
        $habit->delete();

        return redirect()->route('habits.index')->with('success', 'Habit deleted!');
    }
}