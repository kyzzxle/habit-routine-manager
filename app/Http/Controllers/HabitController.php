<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use Illuminate\Http\Request;

class HabitController extends Controller
{
    public function index(Request $request)
    {
        $query = Habit::query();

        if ($request->filled('search')) {
            $query->where('habit_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status') && in_array($request->status, ['Pending', 'Completed'])) {
            $query->where('status', $request->status);
        }

        $habits = $query->latest()->get();

        $total = Habit::count();
        $completed = Habit::where('status', 'Completed')->count();
        $pending = Habit::where('status', 'Pending')->count();
        $percentage = $total > 0 ? round(($completed / $total) * 100) : 0;
        $bestStreak = Habit::max('streak') ?? 0;

        $achievements = [
            'first_habit'       => $total >= 1,
            'seven_day_streak'  => $bestStreak >= 7,
            'ten_completed'     => $completed >= 10,
        ];

        return view('habits.index', compact(
            'habits', 'total', 'completed', 'pending', 'percentage', 'bestStreak', 'achievements'
        ));
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
            'category'    => 'required|in:Health,Study,Fitness,Personal,Productivity',
            'priority'    => 'required|in:Low,Medium,High',
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
            'category'    => 'required|in:Health,Study,Fitness,Personal,Productivity',
            'priority'    => 'required|in:Low,Medium,High',
            'status'      => 'required|in:Pending,Completed',
            'due_date'    => 'nullable|date',
        ]);

        // Simplified streak rule: only award a streak point the moment
        // a habit flips from Pending into Completed.
        if ($habit->status === 'Pending' && $validated['status'] === 'Completed') {
            $validated['streak'] = $habit->streak + 1;
        }

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