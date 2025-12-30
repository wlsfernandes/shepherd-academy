<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use App\Services\SystemLogger;
use App\Helpers\S3Uploader;
use Exception;

class PositionController extends BaseController
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

            'content_en' => ['nullable', 'string'],
            'content_es' => ['nullable', 'string'],

            'image_url' => ['nullable', 'string'],
            'file_url_en' => ['nullable', 'string'],
            'file_url_es' => ['nullable', 'string'],

            'external_link' => ['nullable', 'url'],

            'is_published' => ['nullable', 'boolean'],
            'publish_start_at' => ['nullable', 'date'],
            'publish_end_at' => ['nullable', 'date'],
        ]);
    }

    /**
     * Display a listing of positions.
     */
    public function index()
    {
        $positions = Position::orderByDesc('created_at')->get();

        return view('admin.positions.index', compact('positions'));
    }

    /**
     * Show the form for creating a new position.
     */
    public function create()
    {
        return view('admin.positions.form');
    }

    /**
     * Store a newly created position.
     */
    public function store(Request $request)
    {
        // ✅ Validation first (do NOT wrap in try/catch)
        $data = $this->validatedData($request);

        try {
            $position = Position::create($data);

            SystemLogger::log(
                'Position created',
                'info',
                'positions.store',
                [
                    'position_id' => $position->id,
                    'email' => $request->email,
                ]
            );

            return redirect()
                ->route('positions.index')
                ->with('success', 'Position created successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Position creation failed',
                'error',
                'positions.store',
                [
                    'exception' => $e->getMessage(),
                    'email' => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to create position.');
        }
    }

    /**
     * Show the form for editing the specified position.
     */
    public function edit(Position $position)
    {
        return view('admin.positions.form', compact('position'));
    }

    /**
     * Update the specified position.
     */
    public function update(Request $request, Position $position)
    {
        // ✅ Validation first
        $data = $this->validatedData($request);

        try {
            $position->update($data);

            SystemLogger::log(
                'Position updated',
                'info',
                'positions.update',
                [
                    'position_id' => $position->id,
                    'email' => $request->email,
                ]
            );

            return redirect()
                ->route('positions.index')
                ->with('success', 'Position updated successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Position update failed',
                'error',
                'positions.update',
                [
                    'position_id' => $position->id,
                    'exception' => $e->getMessage(),
                    'email' => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to update position.');
        }
    }

    /**
     * Remove the specified position.
     */
    public function destroy(Position $position)
    {
        try {
            // Cleanup associated S3 assets
            if (!empty($position->image_url)) {
                S3Uploader::deletePath($position->image_url);
            }

            if (!empty($position->file_url_en)) {
                S3Uploader::deletePath($position->file_url_en);
            }

            if (!empty($position->file_url_es)) {
                S3Uploader::deletePath($position->file_url_es);
            }

            $position->delete();

            SystemLogger::log(
                'Position deleted',
                'warning',
                'positions.delete',
                [
                    'position_id' => $position->id,
                    'email' => request()->email,
                ]
            );

            return redirect()
                ->route('positions.index')
                ->with('success', 'Position deleted successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Position deletion failed',
                'error',
                'positions.delete',
                [
                    'position_id' => $position->id,
                    'exception' => $e->getMessage(),
                    'email' => request()->email,
                ]
            );

            return back()
                ->with('error', 'Failed to delete position.');
        }
    }
}
