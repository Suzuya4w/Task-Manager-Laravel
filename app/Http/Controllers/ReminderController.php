<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReminderController extends Controller
{
    public function index()
    {
        $reminders = Auth::user()->reminders()->latest()->get();
        
        // Hitung jumlah reminders yang akan datang
        $remindersCount = Auth::user()->reminders()
            ->where('date', '>=', Carbon::today())
            ->count();
            
        // Ambil reminders yang akan datang (5 terdekat)
        $upcomingReminders = Auth::user()->reminders()
            ->where('date', '>=', Carbon::today())
            ->orderBy('date')
            ->orderBy('time')
            ->take(5)
            ->get();

        return view('reminders.index', compact('reminders', 'remindersCount', 'upcomingReminders'));
    }

    public function create()
    {
        return view('reminders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'time' => 'nullable|date_format:H:i',
            'task_id' => 'nullable|exists:tasks,id' // Tambahkan validasi untuk task_id
        ]);

        Auth::user()->reminders()->create($request->all());

        return redirect()->route('reminders.index')->with('success', 'Reminder created successfully.');
    }

    public function edit(Reminder $reminder)
    {
        return view('reminders.edit', compact('reminder'));
    }

    public function update(Request $request, Reminder $reminder)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'time' => 'nullable|date_format:H:i',
            'task_id' => 'nullable|exists:tasks,id' // Tambahkan validasi untuk task_id
        ]);

        $reminder->update($request->all());

        return redirect()->route('reminders.index')->with('success', 'Reminder updated successfully.');
    }

    public function destroy(Reminder $reminder)
    {
        $reminder->delete();
        return redirect()->route('reminders.index')->with('success', 'Reminder deleted successfully.');
    }
}