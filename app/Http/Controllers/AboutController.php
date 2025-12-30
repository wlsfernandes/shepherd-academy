<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;
use App\Services\SystemLogger;
use App\Helpers\S3Uploader;



class AboutController extends BaseController
{
    /**
     * Validation rules
     * (Project standard: keep before store/update)
     */
    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'title_en' => ['required', 'string', 'max:255'],
            'title_es' => ['nullable', 'string', 'max:255'],

            'subtitle_en' => ['nullable', 'string', 'max:255'],
            'subtitle_es' => ['nullable', 'string', 'max:255'],

            'content_en' => ['nullable', 'string'],
            'content_es' => ['nullable', 'string'],

            'image_url' => ['nullable', 'string'],

            'is_published' => ['nullable', 'boolean'],
            'publish_start_at' => ['nullable', 'date'],
            'publish_end_at' => ['nullable', 'date'],
        ]);
    }

    /**
     * Display a listing of About Us pages.
     */
    public function index()
    {
        $abouts = About::all();

        return view('admin.about.index', compact('abouts'));
    }

    /**
     * Show the form for creating a new About Us page.
     */
    public function create()
    {
        return view('admin.about.form');
    }

    /**
     * Store a newly created About Us page.
     */
    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        $about = About::create($data);

        SystemLogger::log(
            'About Us page created',
            'info',
            'about_us.create',
            [
                'about_us_id' => $about->id,
                'email' => auth()->user()?->email,
                'roles' => auth()->user()?->roles?->pluck('name')->toArray() ?? [],
            ]
        );

        return redirect()
            ->route('about.index')
            ->with('success', 'About Us page created successfully.');
    }

    /**
     * Show the form for editing the specified About Us page.
     */
    public function edit(About $about)
    {
        return view('admin.about.form', compact('about'));
    }

    /**
     * Update the specified About Us page.
     */
    public function update(Request $request, About $about)
    {
        $data = $this->validatedData($request);

        $about->update($data);

        SystemLogger::log(
            'About Us page updated',
            'info',
            'about_us.update',
            [
                'about_us_id' => $about->id,
                'email' => auth()->user()?->email,
                'roles' => auth()->user()?->roles?->pluck('name')->toArray() ?? [],
            ]
        );

        return redirect()
            ->route('about.index')
            ->with('success', 'About Us page updated successfully.');
    }

    /**
     * Remove the specified About Us page.
     */
    public function destroy(About $about)
    {

        if (!empty($about->image_url)) {
            S3Uploader::deletePath($about->image_url);
        }

        $about->delete();

        SystemLogger::log(
            'About Us page deleted',
            'warning',
            'about_us.delete',
            [
                'about_us_id' => $about->id,
                'email' => auth()->user()?->email,
                'roles' => auth()->user()?->roles?->pluck('name')->toArray() ?? [],
            ]
        );

        return redirect()
            ->route('about.index')
            ->with('success', 'About Us page deleted successfully.');
    }
}
