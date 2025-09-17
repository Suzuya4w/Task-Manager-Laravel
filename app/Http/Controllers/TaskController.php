<?php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Project $project)
    {
        // Get tasks grouped by status
        $tasks = [
            'to_do' => $project->tasks()->where('status', 'to_do')->get(),
            'in_progress' => $project->tasks()->where('status', 'in_progress')->get(),
            'completed' => $project->tasks()->where('status', 'completed')->get(),
        ];
        
        $users = $project->users()->get();  
        return view('tasks.index', compact('project', 'tasks', 'users'));
    }

public function store(Request $request, Project $project)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'due_date' => 'nullable|date',
        'priority' => 'required|in:low,medium,high',
        'checklist_items' => 'sometimes|array',
        'checklist_items.*' => 'required|string|max:255',
    ]);

    // Buat tugas baru
    $task = $project->tasks()->create($request->all());

    // Buat checklist items
    if ($request->has('checklist_items')) {
        foreach ($request->checklist_items as $itemName) {
            $task->checklistItems()->create([
                'name' => $itemName,
                'completed' => false
            ]);
        }
    }


    return redirect()->route('projects.tasks.index', $project)
        ->with('success', 'Tugas berhasil dibuat dengan checklist items.');
}

public function upload(Request $request, $id)
{
    $request->validate([
        'file' => 'required|file|max:2048', // maksimal 2MB
    ]);

    $task = Task::findOrFail($id);
    
    // Hapus file lama jika ada
    if ($task->file_path && Storage::exists('public/' . $task->file_path)) {
        Storage::delete('public/' . $task->file_path);
    }
    
    // Simpan file baru
    $path = $request->file('file')->store('tasks', 'public');
    $task->file_path = $path;
    $task->save();

    return redirect()->back()->with('success', 'File uploaded successfully.');
}

public function addNotes(Request $request, $id)
{
    $request->validate([
        'notes' => 'nullable|string',
    ]);

    $task = Task::findOrFail($id);
    $task->notes = $request->notes;
    $task->save();

    return redirect()->back()->with('success', 'Notes saved successfully.');
}

    public function show(Task $task)
    {
        // Muat relasi checklistItems, user, dan project
        $task->load('checklistItems', 'user', 'project');
        return view('tasks.show', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:to_do,in_progress,completed',
        ]);

        $task->update($request->all());

        return redirect()->route('projects.tasks.index', $task->project_id)->with('success', 'Tugas berhasil diperbarui.');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $task->status = $request->input('status');
        $task->save();

        return response()->json(['message' => 'Task status updated successfully.']);
    }
    public function allTasks()
    {
        // Get the authenticated user
        $user = Auth::user();
        
        // Get all project IDs the user has access to (both owned and shared)
        $projectIds = $user->accessibleProjects()->pluck('id');
        
        // Get tasks from all projects the user is involved in
        $tasks = [
            'to_do' => Task::whereIn('project_id', $projectIds)
                        ->where('status', 'to_do')
                        ->with(['project', 'user'])
                        ->get(),
            'in_progress' => Task::whereIn('project_id', $projectIds)
                            ->where('status', 'in_progress')
                            ->with(['project', 'user'])
                            ->get(),
            'completed' => Task::whereIn('project_id', $projectIds)
                        ->where('status', 'completed')
                        ->with(['project', 'user'])
                        ->get(),
        ];
        
        return view('tasks.all', compact('tasks'));
    }

// app/Http/Controllers/TaskController.php

public function list(Request $request)
{
    $user = Auth::user();
    
    $projectIds = $user->accessibleProjects()->pluck('id');
    
    $query = Task::whereIn('project_id', $projectIds)
                ->with(['project', 'user']);
    
    // Apply filters
    $filter = $request->get('filter', 'all');
    
    switch ($filter) {
        case 'with_files':
            $query->whereNotNull('file_path');
            break;
        case 'with_notes':
            $query->whereNotNull('notes');
            break;
        case 'all':
        default:
            break;
    }
    
    $tasks = $query->orderBy('created_at', 'desc')->paginate(15);
    
    return view('tasks.list', compact('tasks', 'filter'));
}
    public function deleteFile($id)
{
    $task = Task::findOrFail($id);
    
    if ($task->file_path && Storage::exists('public/' . $task->file_path)) {
        Storage::delete('public/' . $task->file_path);
        $task->file_path = null;
        $task->save();
    }
    
    return redirect()->back()->with('success', 'File deleted successfully.');
}

}
