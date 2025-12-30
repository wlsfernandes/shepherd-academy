<?php

namespace App\Http\Controllers;
use App\Models\Task;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use Exception;

class LessonController extends Controller
{

    public function show(string $id): View|RedirectResponse
    {
        try {
            $lesson = Lesson::findOrFail($id);
            $task = $lesson->task;
            return view('admin.lesson.form', [
                'lesson' => $lesson,
                'task' => $task,
                'isViewing' => true, // only this is required
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching lesson details: ' . $e->getMessage());
            session()->now('error', 'An error occurred while fetching lesson details.');
            return redirect()->back();
        }
    }
    public function create(Task $task)
    {
        try {
            return view('admin.lesson.form', [
                'task' => $task,
                'formAction' => route('lesson.store', $task),
                'formMethod' => 'POST',
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching lesson details: ' . $e->getMessage());
            session()->now('error', 'An error occurred while fetching lesson details.');
            return redirect()->back();
        }
    }


    public function edit($id)
    {
        try {
            $lesson = Lesson::findOrFail($id);
            $task = $lesson->task;
            return view('admin.lesson.form', [
                'lesson' => $lesson,
                'task' => $task,
                'formAction' => route('lesson.update', $lesson->id),
                'formMethod' => 'PUT',
                'isEditing' => true, // only this is required
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching lesson details: ' . $e->getMessage());
            session()->now('error', 'An error occurred while fetching lesson details.');
            return redirect()->back();
        }
    }

    public function store(Request $request, Task $task)
    {
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);
        try {

            DB::beginTransaction();
            $lesson = new Lesson();
            $lesson->fill($validated);
            $lesson->save();
            DB::commit();

            return redirect()->route('course.index')
                ->with('open_task_id', $lesson->task_id)
                ->with('open_module_id', $lesson->task->module_id)
                ->with('open_course_id', $lesson->task->module->course_id)
                ->with('success', 'Lesson created successfully!');
        } catch (Exception $e) {
            Log::error('Error creating lesson: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while creating the lesson.');
        }
    }



    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $lesson = Lesson::findOrFail($id);
            $lesson->delete();
            DB::commit();
            Log::info('Lesson deleted successfully.');

            return redirect()->route('course.index')
                ->with('open_task_id', $lesson->task_id)
                ->with('open_module_id', $lesson->task->module_id)
                ->with('open_course_id', $lesson->task->module->course_id)
                ->with('success', 'Lesson created successfully!');

        } catch (Exception $e) {
            DB::rollBack();
            session()->now('error', 'deleting lesson: ' . $e->getMessage());
            Log::error('Error deleting lesson: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to delete lesson: ']);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $lesson = Lesson::findOrFail($id);
            $lesson->update($request->all());
            $lesson->save();
            DB::commit();
            return redirect()
                ->route('course.index')
                ->with('open_task_id', $lesson->task_id)
                ->with('open_module_id', $lesson->task->module_id)
                ->with('open_course_id', $lesson->task->module->course_id)
                ->with('success', 'Lesson updated!');
        } catch (Exception $e) {
            DB::rollBack();
            session()->now('error', 'Failed to update Lesson: ' . $e->getMessage());
            Log::error('Error saving lesson: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to update Lesson: ']);
        }
    }

}
