<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use App\Models\Module;
use App\Models\Task;
use Exception;

class TaskController extends Controller
{


    public function show(string $id): View
    {
        try {
            $task = Task::findOrFail($id);
            $module = $task->module;
            return view('admin.task.form', [
                'task' => $task,
                'module' => $module,
                'isViewing' => true,
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching task details: ' . $e->getMessage());
            session()->now('error', 'An error occurred while fetching module details.');
            return redirect()->back();
        }
    }
    public function edit($id)
    {
        try {
            $task = Task::findOrFail($id);
            $module = $task->module;
            return view('admin.task.form', [
                'task' => $task,
                'module' => $module,
                'formAction' => route('task.update', $task->id),
                'formMethod' => 'PUT',
                'isEditing' => true, // only this is required
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching task details: ' . $e->getMessage());
            session()->now('error', 'An error occurred while fetching task details.');
            return redirect()->back();
        }
    }
    public function create(Module $module)
    {
        try {
            return view('admin.task.form', [
                'module' => $module,
                'formAction' => route('task.store', $module),
                'formMethod' => 'POST',
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching task details: ' . $e->getMessage());
            session()->now('error', 'An error occurred while fetching module details.');
            return redirect()->back();
        }
    }
    public function store(Request $request, Module $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'module_id' => 'required|exists:modules,id',
        ]);

        try {
            DB::beginTransaction();
            $task = new Task();
            $task->fill($validated);
            $task->save();
            DB::commit();
            return redirect()->route('course.index')
                ->with('open_module_id', $task->module_id)
                ->with('open_course_id', $task->module->course_id)
                ->with('success', 'Task created successfully!');
        } catch (Exception $e) {
            Log::error('Error creating task: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while creating the task.');
        }
    }


    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $task = Task::findOrFail($id);
            $task->delete();
            DB::commit();
            Log::info('Task deleted successfully.');
            return redirect()->route('course.index')
                ->with('open_module_id', $task->module_id)
                ->with('open_course_id', $task->module->course_id)
                ->with('success', 'Task Deleted successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            session()->now('error', 'deleting task: ' . $e->getMessage());
            Log::error('Error deleting task: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to delete task: ']);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $task = Task::findOrFail($id);
            $task->update($request->all());
            $task->save();
            DB::commit();
            Log::info('Task updated successfully.');
            return redirect()->route('course.index')
                ->with('open_module_id', $task->module_id)
                ->with('open_course_id', $task->module->course_id)
                ->with('success', 'Task Updated successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            session()->now('error', 'Failed to update Task: ' . $e->getMessage());
            Log::error('Error saving task: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to update Task: ']);
        }
    }
}
