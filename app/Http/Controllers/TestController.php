<?php

namespace App\Http\Controllers;
use App\Models\Task;
use App\Models\Test;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class TestController extends Controller
{

    public function show(string $id): View
    {
        try {
            $test = Test::findOrFail($id);
            $task = $test->task;
            return view('admin.test.form', [
                'test' => $test,
                'task' => $task,
                'isViewing' => true, // only this is required
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching test details: ' . $e->getMessage());
            session()->now('error', 'An error occurred while fetching test details.');
            return redirect()->back();
        }
    }
    public function create(Task $task)
    {
        try {
            return view('admin.test.form', [
                'task' => $task,
                'formAction' => route('test.store', $task),
                'formMethod' => 'POST',
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching test details: ' . $e->getMessage());
            session()->now('error', 'An error occurred while fetching test details.');
            return redirect()->back();
        }
    }


    public function edit($id)
    {
        try {
            $test = Test::with('questions.options')->findOrFail($id);
            $task = $test->task;
            return view('admin.test.form', [
                'test' => $test,
                'task' => $task,
                'formAction' => route('test.update', $test->id),
                'formMethod' => 'PUT',
                'isEditing' => true, // only this is required
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching test details: ' . $e->getMessage());
            session()->now('error', 'An error occurred while fetching test details.');
            return redirect()->back();
        }
    }

    public function store(Request $request, Task $task)
    {
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'title' => 'required|string|max:255',

            'questions' => 'required|array|min:1',
            'questions.*.description' => 'required|string',

            'questions.*.options' => 'required|array|size:4',
            'questions.*.options.*.text' => 'required|string',

            'questions.*.correct' => 'required|in:0,1,2,3',
        ]);
        try {

            DB::beginTransaction();
            $test = new Test();
            $test->fill($validated);
            $test->save();

            foreach ($request->questions as $q) {
                $question = $test->questions()->create([
                    'description' => $q['description'],
                ]);

                foreach ($q['options'] as $index => $optionData) {
                    $question->options()->create([
                        'text' => $optionData['text'],
                        'is_correct' => (int) $q['correct'] === $index,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('course.index')
                ->with('open_task_id', $test->task_id)
                ->with('open_module_id', $test->task->module_id)
                ->with('open_course_id', $test->task->module->course_id)
                ->with('success', 'Test created successfully!');
        } catch (Exception $e) {
            Log::error('Error creating test: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while creating the test.');
        }
    }



    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $test = Test::findOrFail($id);
            $test->delete();
            DB::commit();
            Log::info('Test deleted successfully.');

            return redirect()->route('course.index')
                ->with('open_task_id', $test->task_id)
                ->with('open_module_id', $test->task->module_id)
                ->with('open_course_id', $test->task->module->course_id)
                ->with('success', 'Test created successfully!');

        } catch (Exception $e) {
            DB::rollBack();
            session()->now('error', 'deleting test: ' . $e->getMessage());
            Log::error('Error deleting test: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to delete test: ']);
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'questions' => 'nullable|array',
            'questions.*.description' => 'required|string',
            'questions.*.options' => 'required|array|size:4',
            'questions.*.options.*.text' => 'required|string',
            'questions.*.correct' => 'required|in:0,1,2,3',
        ]);

        try {
            DB::beginTransaction();

            $test = Test::with('questions.options')->findOrFail($id);
            $test->update(['title' => $validated['title']]);

            // 🔴 Delete removed questions
            $deletedIds = collect(explode(',', $request->input('deleted_questions')))
                ->filter()
                ->map(fn($id) => (int) $id)
                ->all();

            if (!empty($deletedIds)) {
                Question::whereIn('id', $deletedIds)->delete();
            }

            // 🔁 Save or update questions and options
            foreach ($request->questions ?? [] as $qData) {
                if (isset($qData['id'])) {
                    // Update existing question
                    $question = \App\Models\Question::find($qData['id']);
                    if ($question) {
                        $question->update(['description' => $qData['description']]);
                        foreach ($qData['options'] as $i => $optData) {
                            $option = $question->options[$i] ?? null;
                            if ($option) {
                                $option->update([
                                    'text' => $optData['text'],
                                    'is_correct' => (int) $qData['correct'] === $i,
                                ]);
                            }
                        }
                    }
                } else {
                    // Create new question
                    $question = $test->questions()->create([
                        'description' => $qData['description'],
                    ]);

                    foreach ($qData['options'] as $i => $optData) {
                        $question->options()->create([
                            'text' => $optData['text'],
                            'is_correct' => (int) $qData['correct'] === $i,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()
                ->route('course.index')
                ->with('open_task_id', $test->task_id)
                ->with('open_module_id', $test->task->module_id)
                ->with('open_course_id', $test->task->module->course_id)
                ->with('success', 'Test updated!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error saving test: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors([
                'error' => 'Failed to update Test: ' . $e->getMessage()
            ]);
        }
    }


}
