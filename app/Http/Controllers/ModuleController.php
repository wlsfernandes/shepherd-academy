<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use App\Models\Course;
use App\Models\Module;
use Exception;

class ModuleController extends Controller
{

    public function show(string $id): View
    {
        try {
            $module = Module::findOrFail($id);
            $course = $module->course;
            return view('admin.module.form', [
                'module' => $module,
                'course' => $course,
                'isViewing' => true,
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching module details: ' . $e->getMessage());
            session()->now('error', 'An error occurred while fetching module details.');
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        try {
            $module = Module::findOrFail($id);
            $course = $module->course;
            return view('admin.module.form', [
                'module' => $module,
                'course' => $course,
                'formAction' => route('module.update', $module->id),
                'formMethod' => 'PUT',
                'isEditing' => true,
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching module details: ' . $e->getMessage());
            session()->now('error', 'An error occurred while fetching module details.');
            return redirect()->back();
        }
    }

    public function create(Course $course)
    {
        try {
            return view('admin.module.form', [
                'course' => $course,
                'formAction' => route('module.store'),
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching module details: ' . $e->getMessage());
            session()->now('error', 'An error occurred while fetching module details.');
            return redirect()->back();
        }
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();
            $module = new Module();
            $module->fill($validated);
            $module->save();
            DB::commit();

            return redirect()->route('course.index')
                ->with('open_module_id', $module->module_id)
                ->with('open_course_id', $module->course_id)
                ->with('success', 'Module Created successfully!');
        } catch (Exception $e) {
            Log::error('Error creating module: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while creating the module.');
        }
    }

    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $module = Module::findOrFail($id);
            $module->delete();
            DB::commit();
            Log::info('Module deleted successfully.');
            return redirect()->route('course.index')
                ->with('open_module_id', $module->module_id)
                ->with('open_course_id', $module->course_id)
                ->with('success', 'Module Created successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            session()->now('error', 'deleting course: ' . $e->getMessage());
            Log::error('Error deleting course: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to delete course: ']);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $module = Module::findOrFail($id);
            $module->update($request->all());
            $module->save();
            DB::commit();
            Log::info('Module updated successfully.');

            return redirect()->route('course.index')
                ->with('open_module_id', $module->module_id)
                ->with('open_course_id', $module->course_id)
                ->with('success', 'Module Created successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            session()->now('error', 'Failed to update Module: ' . $e->getMessage());
            Log::error('Error saving module: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to update Module: ']);
        }
    }

}
