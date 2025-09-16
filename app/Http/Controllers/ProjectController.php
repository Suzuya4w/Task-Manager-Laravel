<?php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
public function index()
{
    $user = Auth::user();
    
    $projects = Project::where('user_id', $user->id)
        ->orWhereHas('users', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->with(['tasks']) 
        ->withCount([
            'tasks as to_do_tasks' => function ($query) {
                $query->where('status', 'to_do');
            }, 
            'tasks as in_progress_tasks' => function ($query) {
                $query->where('status', 'in_progress');
            }, 
            'tasks as completed_tasks' => function ($query) {
                $query->where('status', 'completed');
            }
        ])
        ->get();

    return view('projects.index', compact('projects'));
}



    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'budget' => 'nullable|numeric',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();

        Project::create($data);

        return redirect()->route('projects.index')->with('success', 'Proyek berhasil dibuat.');
    }

    public function show(Project $project)
    {
        // Check if user has access to this project (either owner or team member)
        $user = Auth::user();
        
        if ($project->user_id !== $user->id && !$project->users()->where('user_id', $user->id)->exists()) {
            abort(403, 'Unauthorized access to this project.');
        }
        
        $teamMembers = $project->users()->get();
        $users = User::where('id', '!=', $user->id)->get(); // Exclude current user
        
        return view('projects.show', compact('project', 'teamMembers', 'users'));
    }
    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'budget' => 'nullable|numeric',
        ]);

        $project->update($request->only(['name', 'description', 'start_date', 'end_date', 'budget']));

        return redirect()->route('projects.index')->with('success', 'Proyek berhasil diperbarui.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        $project->tasks()->delete();

        return redirect()->route('projects.index')->with('success', 'Proyek berhasil dihapus.');
    }

    public function addMember(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'required|exists:users,id',
        ]);
    
        $project = Project::find($request->project_id);
        
        // Check if user is already a member
        if ($project->users()->where('user_id', $request->user_id)->exists()) {
            return redirect()->back()->with('error', 'Pengguna sudah menjadi anggota proyek ini.');
        }
        
        // Add user to project team
        $project->users()->attach($request->user_id);
        
        return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan.');
    }
}
