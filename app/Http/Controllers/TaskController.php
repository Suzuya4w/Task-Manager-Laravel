<?php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
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
        ]);

        $project->tasks()->create($request->all());

        return redirect()->route('projects.tasks.index', $project)->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
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

        return redirect()->route('projects.tasks.index', $task->project_id)->with('success', 'Task updated successfully.');
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
}
