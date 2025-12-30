<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Course;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Exception;

class CourseController extends Controller
{
    public function index(): View
    {
        try {
            $courses = Course::with('modules.tasks.lessons', 'modules.tasks.files', 'modules.tasks.tests')->get();
            return view('admin.course.index', compact('courses'));
        } catch (Exception $e) {
            Log::error('Error fetching courses: ' . $e->getMessage());
            session()->now('error', 'An error occurred while fetching courses.');
            return redirect()->back();
        }
    }


    public function create()
    {
        return view('admin.course.form', [
            'course' => new Course(),
            'formAction' => route('course.store'),
            'formMethod' => 'POST',
        ]);
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);

        return view('admin.course.form', [
            'course' => $course,
            'formAction' => route('course.update', $course->id),
            'formMethod' => 'PUT',
            'isEditing' => true, // only this is required
        ]);
    }


    public function show(string $id): View
    {
        try {
            $course = Course::findOrFail($id);
            return view('admin.course.form', [
                'course' => $course,
                'isViewing' => true, // only this is required
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching course details: ' . $e->getMessage());
            session()->now('error', 'An error occurred while fetching course details.');
            return redirect()->back();
        }
    }


    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $course = Course::findOrFail($id);
            $course->delete();
            DB::commit();
            session()->flash('success', 'Course deleted successfully.');
            Log::info('Course deleted successfully.');
            return redirect()->route('course.index');
        } catch (Exception $e) {
            DB::rollBack();
            session()->now('error', 'deleting course: ' . $e->getMessage());
            Log::error('Error deleting course: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to delete course: ']);
        }
    }




    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            //    $request->merge(['amount' => $request->input('amount', 0.00)]);
            $course = new Course($request->all());
            $course->institution_id = auth_institution_id();
            $course->save();
            DB::commit();
            session()->flash('success', 'Course included successfully.'); // Flashing success message
            Log::info('Course included successfully.');
            return redirect()->route('course.index');
        } catch (Exception $e) {
            DB::rollBack();
            session()->now('error', 'Failed to include Course: ' . $e->getMessage());
            Log::error('Error saving Course: ' . $e->getMessage());
            // return redirect()->back()->withInput()->withErrors(['error' => 'Failed to include course: ']);
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }



    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $course = Course::findOrFail($id);
            $course->update($request->all());
            $course->institution_id = auth_institution_id();
            $course->save();
            DB::commit();
            session()->flash('success', 'Course updated successfully.');
            Log::info('Course updated successfully.');
            return redirect()->route('course.index');
        } catch (Exception $e) {
            DB::rollBack();
            session()->now('error', 'Failed to update Course: ' . $e->getMessage());
            Log::error('Error saving course: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to update Course: ']);
        }
    }

    /************************** View  */



}
