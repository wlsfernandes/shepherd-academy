<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Services\SystemLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;
use App\Helpers\S3;

class BannerController extends BaseController
{
    /**
     * List all banners (published + drafts).
     */
    public function index()
    {
        $banners = Banner::orderBy('sort_order')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Show create form.
     */
    public function create()
    {
        return view('admin.banners.form');
    }

    /**
     * Store new banners.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_es' => 'nullable|string|max:255',

            'subtitle_en' => 'nullable|string',
            'subtitle_es' => 'nullable|string',

            'link' => 'nullable|url|max:255',
            'open_in_new_tab' => 'nullable|boolean',

            'publish_start_at' => 'nullable|date',
            'publish_end_at' => 'nullable|date|after_or_equal:publish_start_at',

            'is_published' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        try {
            DB::transaction(function () use ($request) {
                Banner::create([
                    'title_en' => $request->title_en,
                    'title_es' => $request->title_es,

                    'subtitle_en' => $request->subtitle_en,
                    'subtitle_es' => $request->subtitle_es,

                    'link' => $request->link,
                    'open_in_new_tab' => (bool) $request->open_in_new_tab,

                    'publish_start_at' => $request->publish_start_at,
                    'publish_end_at' => $request->publish_end_at,
                    'is_published' => (bool) $request->is_published,

                    'sort_order' => $request->sort_order ?? 0,
                ]);
            });
            SystemLogger::log(
                'Banner created',
                'info',
                'banners.store',
                [
                    'email' => $request->email,
                    'roles' => $request->roles ?? [],
                ]
            );
            return redirect()
                ->route('banners.index')
                ->with('success', 'Banner created successfully.');

        } catch (Throwable $e) {

            SystemLogger::log(
                'Banner creation failed',
                'error',
                'banners.store',
                [
                    'exception' => $e->getMessage(),
                    'email' => $request->email,
                ]
            );
            return back()
                ->withInput()
                ->with('error', 'Failed to create banners.');
        }
    }

    /**
     * Show edit form.
     */
    public function edit(Banner $banner)
    {
        return view('admin.banners.form', compact('banner'));
    }

    /**
     * Update banners.
     */
    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_es' => 'nullable|string|max:255',
            'title_pt' => 'nullable|string|max:255',

            'subtitle_en' => 'nullable|string',
            'subtitle_es' => 'nullable|string',
            'subtitle_pt' => 'nullable|string',

            'link' => 'nullable|url|max:255',
            'open_in_new_tab' => 'nullable|boolean',

            'publish_start_at' => 'nullable|date',
            'publish_end_at' => 'nullable|date|after_or_equal:publish_start_at',

            'is_published' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        try {
            DB::transaction(function () use ($request, $banner) {
                $banner->update($request->only([
                    'title_en',
                    'title_es',
                    'title_pt',
                    'subtitle_en',
                    'subtitle_es',
                    'subtitle_pt',
                    'link',
                    'open_in_new_tab',
                    'publish_start_at',
                    'publish_end_at',
                    'is_published',
                    'sort_order',
                ]));
            });
            SystemLogger::log(
                'Banner updated',
                'info',
                'banners.update',
                [
                    'email' => $request->email,
                    'roles' => $request->roles ?? [],
                ]
            );
            return redirect()
                ->route('banners.index')
                ->with('success', 'Banner updated successfully.');

        } catch (Throwable $e) {
            SystemLogger::log(
                'Banner creation failed',
                'error',
                'banners.update',
                [
                    'exception' => $e->getMessage(),
                    'email' => $request->email,
                ]
            );
            return back()
                ->with('error', 'Failed to update banners.');
        }
    }

    /**
     * Delete banners.
     */
    public function destroy(Banner $banner)
    {
        try {
            // 🔥 Delete image from storage if exists
            if (!empty($banner->image_url)) {
                S3::delete($banner->image_url);
            }

            $banner->delete();

            SystemLogger::log(
                'Banner deleted',
                'info',
                'banners.delete',
                [
                    'banner_id' => $banner->id,
                    'title' => $banner->title_en,
                ]
            );

            return redirect()
                ->route('banner.index')
                ->with('success', 'Banner deleted successfully.');

        } catch (Throwable $e) {
            SystemLogger::log(
                'Banner deletion failed',
                'error',
                'banners.delete',
                [
                    'banner_id' => $banner->id ?? null,
                    'exception' => $e->getMessage(),
                ]
            );

            return back()->with('error', 'Failed to delete banner.');
        }
    }
}
