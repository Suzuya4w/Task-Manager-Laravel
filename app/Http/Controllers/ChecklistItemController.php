<?php
namespace App\Http\Controllers;

use App\Models\ChecklistItem;
use App\Models\Task;
use Illuminate\Http\Request;

class ChecklistItemController extends Controller
{
    public function store(Request $request, $taskId)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:191',
        ]);

        $checklistItem = ChecklistItem::create([
            'task_id' => $taskId,
            'name' => $request->name,
            'completed' => false,
        ]);

        return response()->json(['success' => true, 'message' => 'Checklist item ditambahkan.']);
    }

    public function upload(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|file|max:2048', // Maksimal 2MB
        ]);

        $checklistItem = ChecklistItem::findOrFail($id);
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('checklist_files', 'public');
            $checklistItem->update(['file_path' => $path]);
        }

        return redirect()->back()->with('success', 'File berhasil diunggah.');
    }

    public function addNotes(Request $request, $id)
    {
        $request->validate([
            'notes' => 'nullable|string',
        ]);

        $checklistItem = ChecklistItem::findOrFail($id);
        $checklistItem->update(['notes' => $request->notes]);

        return redirect()->back()->with('success', 'Catatan berhasil disimpan.');
    }

    public function deleteFile($id)
    {
        $checklistItem = ChecklistItem::findOrFail($id);
        if ($checklistItem->file_path) {
            \Storage::disk('public')->delete($checklistItem->file_path);
            $checklistItem->update(['file_path' => null]);
        }

        return redirect()->back()->with('success', 'File berhasil dihapus.');
    }

    public function updateStatus(Request $request, $id)
    {
        $checklistItem = ChecklistItem::findOrFail($id);
        $checklistItem->update(['completed' => $request->completed]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $checklistItem = ChecklistItem::findOrFail($id);
        if ($checklistItem->file_path) {
            \Storage::disk('public')->delete($checklistItem->file_path);
        }
        $checklistItem->delete();

        return response()->json(['success' => true]);
    }
}