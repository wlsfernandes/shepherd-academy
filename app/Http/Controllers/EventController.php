<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class EventController extends BaseController
{
    /**
     * List all events (published + drafts).
     */
    public function index()
    {
        $events = Event::orderByDesc('event_date')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.events.index', compact('events'));
    }

    /**
     * Show create form.
     */
    public function create()
    {
        return view('admin.events.form');
    }

    /**
     * Store new event.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_es' => 'nullable|string|max:255',
            'content_en' => 'nullable|string',
            'content_es' => 'nullable|string',
            'event_date' => 'nullable|date',
            'publish_start_at' => 'nullable|date',
            'publish_end_at' => 'nullable|date|after_or_equal:publish_start_at',
            'is_published' => 'nullable|boolean',
            'image_url' => 'nullable|string|max:255',
            'file_url_en' => 'nullable|string|max:255',
            'file_url_es' => 'nullable|string|max:255',
            'external_link' => 'nullable|url|max:255',
        ]);

        try {
            DB::transaction(function () use ($request) {
                Event::create([
                    'title_en' => $request->title_en,
                    'title_es' => $request->title_es,
                    'content_en' => $request->content_en,
                    'content_es' => $request->content_es,
                    'event_date' => $request->event_date,
                    'publish_start_at' => $request->publish_start_at,
                    'publish_end_at' => $request->publish_end_at,
                    'is_published' => (bool) $request->is_published,
                    'image_url' => $request->image_url,
                    'file_url_en' => $request->file_url_en,
                    'file_url_es' => $request->file_url_es,
                    'external_link' => $request->external_link,
                ]);
            });

            return redirect()
                ->route('events.index')
                ->with('success', 'Event created successfully.');

        } catch (Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create event.');
        }
    }

    /**
     * Show edit form.
     */
    public function edit(Event $event)
    {
        return view('admin.events.form', compact('event'));
    }

    /**
     * Update event.
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_es' => 'nullable|string|max:255',
            'content_en' => 'nullable|string',
            'content_es' => 'nullable|string',
            'event_date' => 'nullable|date',
            'publish_start_at' => 'nullable|date',
            'publish_end_at' => 'nullable|date|after_or_equal:publish_start_at',
            'is_published' => 'nullable|boolean',
            'image_url' => 'nullable|string|max:255',
            'file_url_en' => 'nullable|string|max:255',
            'file_url_es' => 'nullable|string|max:255',
            'external_link' => 'nullable|url|max:255',
        ]);

        try {
            DB::transaction(function () use ($request, $event) {
                $event->update($request->only([
                    'title_en',
                    'title_es',
                    'summary_en',
                    'summary_es',
                    'content_en',
                    'content_es',
                    'event_date',
                    'publish_start_at',
                    'publish_end_at',
                    'is_published',
                    'image_url',
                    'file_url_en',
                    'file_url_es',
                    'external_link',
                ]));
            });

            return redirect()
                ->route('events.index')
                ->with('success', 'Event updated successfully.');

        } catch (Throwable $e) {
            return back()
                ->with('error', 'Failed to update event.');
        }
    }

    /**
     * Delete event.
     */
    public function destroy(Event $event)
    {
        try {
            $event->delete();

            return redirect()
                ->route('events.index')
                ->with('success', 'Event deleted successfully.');

        } catch (Throwable $e) {
            return back()->with('error', 'Failed to delete event.');
        }
    }
}
