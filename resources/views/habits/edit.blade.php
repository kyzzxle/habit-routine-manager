@extends('layouts.app')

@section('page-title', 'Edit Habit')

@section('content')
    <style>
        .form-page { max-width: 600px; background: var(--white); border: 1px solid var(--border); border-radius: 16px; padding: 32px; }
        .form-group { margin-bottom: 20px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        label { display: block; font-size: 13.5px; font-weight: 600; margin-bottom: 7px; }
        input[type=text], input[type=date], textarea, select {
            width: 100%; padding: 11px 13px; border: 1px solid var(--border); border-radius: 9px; font-family: inherit; font-size: 14px; background: var(--white);
        }
        input:focus, textarea:focus, select:focus { outline: none; border-color: var(--indigo); box-shadow: 0 0 0 3px rgba(79,70,229,0.12); }
        .error-text { color: var(--danger); font-size: 12.5px; margin-top: 5px; }
        .form-actions { display: flex; gap: 10px; margin-top: 6px; }
        .streak-note { font-size: 12.5px; color: var(--text-muted); background: #F8FAFC; border: 1px solid var(--border); padding: 10px 14px; border-radius: 9px; margin-bottom: 20px; }
    </style>

    <div class="form-page">

        @if($habit->streak > 0)
            <div class="streak-note">🔥 Current streak: <strong>{{ $habit->streak }} day(s)</strong></div>
        @endif

        <form action="{{ route('habits.update', $habit->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="habit_name">Habit Name</label>
                <input type="text" name="habit_name" id="habit_name" value="{{ old('habit_name', $habit->habit_name) }}">
                @error('habit_name') <div class="error-text">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" rows="3">{{ old('description', $habit->description) }}</textarea>
                @error('description') <div class="error-text">{{ $message }}</div> @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="category">Category</label>
                    <select name="category" id="category">
                        @foreach(['Health','Study','Fitness','Personal','Productivity'] as $cat)
                            <option value="{{ $cat }}" {{ old('category', $habit->category) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    @error('category') <div class="error-text">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="priority">Priority</label>
                    <select name="priority" id="priority">
                        @foreach(['Low','Medium','High'] as $p)
                            <option value="{{ $p }}" {{ old('priority', $habit->priority) === $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                    @error('priority') <div class="error-text">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status">
                        <option value="Pending" {{ old('status', $habit->status) === 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Completed" {{ old('status', $habit->status) === 'Completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    @error('status') <div class="error-text">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="due_date">Due Date</label>
                    <input type="date" name="due_date" id="due_date"
                        value="{{ old('due_date', $habit->due_date ? \Carbon\Carbon::parse($habit->due_date)->format('Y-m-d') : '') }}">
                    @error('due_date') <div class="error-text">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Habit</button>
                <a href="{{ route('habits.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection