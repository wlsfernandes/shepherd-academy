<?php

namespace App\Http\Controllers;
use App\Models\Task;
use App\Helpers\S3Uploader;
use App\Helpers\S3FolderGenerator;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use Exception;

class FileController extends Controller
{

    public function show(string $id): View|RedirectResponse
    {
        try {
            $file = File::findOrFail($id);
            $task = $file->task;
            return view('admin.file.form', [
                'file' => $file,
                'task' => $task,
                'isViewing' => true, // only this is required
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching file details: ' . $e->getMessage());
            session()->now('error', 'An error occurred while fetching file details.');
            return redirect()->back();
        }
    }
    public function create(Task $task)
    {
        try {
            // 👇 Your existing subfolder logic (kept)
            $folder = S3FolderGenerator::createFolder('tasks/' . $task->id);

            return view('admin.file.form', [
                'task' => $task,
                'formAction' => route('file.store', $task),
                'formMethod' => 'POST',
                'folder' => $folder,
            ]);

        } catch (Exception $e) {
            Log::error('Error fetching file details', [
                'task_id' => $task->id ?? null,
                'error' => $e->getMessage(),
            ]);

            session()->now('error', 'An error occurred while preparing the file upload.');
            return redirect()->back();
        }
    }


    public function edit($id)
    {
        try {
            $file = File::findOrFail($id);
            $task = $file->task;
            return view('admin.file.form', [
                'file' => $file,
                'task' => $task,
                'formAction' => route('file.update', $file->id),
                'formMethod' => 'PUT',
                'isEditing' => true, // only this is required
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching file details: ' . $e->getMessage());
            session()->now('error', 'An error occurred while fetching file details.');
            return redirect()->back();
        }
    }

    public function store(Request $request, Task $task)
    {
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'title' => 'required|string|max:255',
            'filename' => 'required|string',
            'type' => 'nullable|string',
            'key' => 'required|string', // 👈 Presigned S3 key (already uploaded)
        ]);

        try {
            DB::beginTransaction();

            $file = new File();
            $file->title = $validated['title'];
            $file->task_id = $validated['task_id'];
            $file->url = S3Uploader::buildPublicUrl($validated['key']);
            $file->s3_key = $validated['key'];
            $file->save();

            DB::commit();

            return redirect()->route('course.index')
                ->with('open_task_id', $file->task_id)
                ->with('open_module_id', $file->task->module_id)
                ->with('open_course_id', $file->task->module->course_id)
                ->with('success', 'File saved successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error saving file: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to save file.');
        }
    }


    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $file = File::findOrFail($id);
            if ($file->s3_key) {
                S3Uploader::deletePath($file->s3_key);
            }
            $file->delete();
            DB::commit();
            return redirect()->route('course.index')
                ->with('open_task_id', $file->task_id)
                ->with('open_module_id', $file->task->module_id)
                ->with('open_course_id', $file->task->module->course_id)
                ->with('success', 'File deleted successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error deleting file: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to delete file: ' . $e->getMessage()]);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $file = File::findOrFail($id);
            $file->update($request->all());
            $file->save();
            DB::commit();
            return redirect()
                ->route('course.index')
                ->with('open_task_id', $file->task_id)
                ->with('open_module_id', $file->task->module_id)
                ->with('open_course_id', $file->task->module->course_id)
                ->with('success', 'File updated!');
        } catch (Exception $e) {
            DB::rollBack();
            session()->now('error', 'Failed to update File: ' . $e->getMessage());
            Log::error('Error saving file: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to update File: ']);
        }
    }

}
