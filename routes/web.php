<?php
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ChecklistItemController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectFileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('register', [RegisteredUserController::class, 'store']);

Route::middleware(['auth'])->group(function () {
    Route::controller(MailController::class)->prefix('mail')->name('mail.')->group(function () {
        Route::get('/', 'index')->name('inbox');
    });
    Route::resource('projects', ProjectController::class);
    Route::post('projects/add-member', [ProjectController::class, 'addMember'])->name('projects.addMember');
    Route::get('projects/{project}/tasks', [TaskController::class, 'index'])->name('projects.tasks.index');
    Route::post('projects/{project}/tasks', [TaskController::class, 'store'])->name('projects.tasks.store');
    Route::put('projects/{project}/status', [ProjectController::class, 'updateStatus'])->name('projects.updateStatus');

    Route::get('tasks', [TaskController::class, 'allTasks'])->name('tasks.index');
    Route::get('tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::put('tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::post('tasks/{task}/update-status', [TaskController::class, 'updateStatus']);
    Route::get('list', [TaskController::class, 'list'])->name('tasks.list');
    Route::post('/tasks/{id}/upload', [TaskController::class, 'upload'])->name('tasks.upload');
    Route::post('/tasks/{id}/notes', [TaskController::class, 'addNotes'])->name('tasks.add-notes');
    Route::delete('/tasks/{id}/delete-file', [TaskController::class, 'deleteFile'])->name('tasks.delete-file');

    Route::post('/checklist-items/{id}/upload', [ChecklistItemController::class, 'upload'])->name('checklist-items.upload');
    Route::post('/checklist-items/{id}/notes', [ChecklistItemController::class, 'addNotes'])->name('checklist-items.add-notes');
    Route::delete('/checklist-items/{id}/delete-file', [ChecklistItemController::class, 'deleteFile'])->name('checklist-items.delete-file');

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');

    Route::resource('notes', NoteController::class);
    Route::resource('checklist-items', ChecklistItemController::class);
    Route::get('checklist-items/{checklistItem}/update-status', [ChecklistItemController::class, 'updateStatus'])->name('checklist-items.update-status');
    Route::get('/', function () {
        $user = Auth::user();
        $projectsCount = $user->projects()->count();
        $tasksCount = $user->tasks()->count();
        $notesCount = $user->notes()->count();
        $recentTasks = $user->tasks()->latest()->take(5)->get();
        $recentNotes = $user->notes()->latest()->take(5)->get();

        return view('dashboard', compact(
            'projectsCount',
            'tasksCount', 
            'notesCount', 
            'recentTasks', 
            'recentNotes', 
        ));
    })->name('dashboard');
});
