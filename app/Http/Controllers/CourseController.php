<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Course;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use App\Services\SystemLogger;
use Exception;

class CourseController extends BaseController
{

    /*
     |--------------------------------------------------------------------------
     | Validation (Separated on Purpose)
     |--------------------------------------------------------------------------
     */
    protected function validateStore(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'image_url' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'allow_installments' => 'nullable|boolean',
            'installment_count' => [
                'nullable',
                'integer',
                'min:1',
                'required_if:allow_installments,1',
            ],
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_published' => 'nullable|boolean',
            'publish_start_at' => 'nullable|date',
            'publish_end_at' => 'nullable|date|after_or_equal:publish_start_at',
        ]);

    }

    protected function validateUpdate(Request $request): array
    {
        // Same rules for now — separated for future divergence
        return $this->validateStore($request);
    }

    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */
    public function index(): View|RedirectResponse
    {
        try {
            $courses = Course::with('modules.tasks.lessons', 'modules.tasks.files', 'modules.tasks.tests')->get();
            return view('admin.course.index', compact('courses'));
        } catch (Exception $e) {
            SystemLogger::log(
                'Failed to fetch courses',
                'error',
                'course.index',
                ['exception' => $e->getMessage()]
            );

            session()->now('error', 'An error occurred while fetching courses.');
            return redirect()->back();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Create / Edit / Show
    |--------------------------------------------------------------------------
    */
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
            'isEditing' => true,
        ]);
    }

    public function show(string $id): View|RedirectResponse
    {
        try {
            $course = Course::findOrFail($id);

            return view('admin.course.form', [
                'course' => $course,
                'isViewing' => true,
            ]);

        } catch (Exception $e) {
            SystemLogger::log(
                'Failed to view course',
                'error',
                'course.show',
                ['exception' => $e->getMessage()]
            );

            session()->now('error', 'An error occurred while fetching course details.');
            return redirect()->back();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $validated = $this->validateStore($request);

        try {
            DB::beginTransaction();

            $course = new Course($validated);
            $course->institution_id = auth_institution_id();
            $course->slug = Course::generateUniqueSlug($course);
            $course->save();

            DB::commit();

            SystemLogger::log(
                'Course created',
                'info',
                'course.store',
                [
                    'course_id' => $course->id,
                    'institution_id' => $course->institution_id,
                ]
            );

            session()->flash('success', 'Course included successfully.');
            return redirect()->route('course.index');

        } catch (Exception $e) {
            DB::rollBack();

            SystemLogger::log(
                'Failed to create course',
                'error',
                'course.store',
                ['exception' => $e->getMessage()]
            );

            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to include course.']);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $validated = $this->validateUpdate($request);

        try {
            DB::beginTransaction();

            $course = Course::findOrFail($id);
            $course->fill($validated);
            $course->institution_id = auth_institution_id();
            $course->slug = Course::generateUniqueSlug($course);
            $course->save();

            DB::commit();

            SystemLogger::log(
                'Course updated',
                'info',
                'course.update',
                ['course_id' => $course->id]
            );

            session()->flash('success', 'Course updated successfully.');
            return redirect()->route('course.index');

        } catch (Exception $e) {
            DB::rollBack();

            SystemLogger::log(
                'Failed to update course',
                'error',
                'course.update',
                ['exception' => $e->getMessage()]
            );

            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to update course.']);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Destroy
    |--------------------------------------------------------------------------
    */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $course = Course::findOrFail($id);
            $course->delete();

            DB::commit();

            SystemLogger::log(
                'Course deleted',
                'info',
                'course.destroy',
                ['course_id' => $id]
            );

            session()->flash('success', 'Course deleted successfully.');
            return redirect()->route('course.index');

        } catch (Exception $e) {
            DB::rollBack();

            SystemLogger::log(
                'Failed to delete course',
                'error',
                'course.destroy',
                ['exception' => $e->getMessage()]
            );

            return redirect()->back()->withErrors(['error' => 'Failed to delete course.']);
        }
    }


}
