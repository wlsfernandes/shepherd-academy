<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use App\Services\SystemLogger;
use App\Helpers\S3;
use Exception;

class TeamController extends BaseController
{
    /**
     * Validation rules
     * (Project standard: before store/update)
     */
    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],

            'content_en' => ['nullable', 'string'],
            'content_es' => ['nullable', 'string'],

            'image_url' => ['nullable', 'string'],

            'is_published' => ['nullable', 'boolean'],
        ]);
    }

    /**
     * Display a listing of team members.
     */
    public function index()
    {
        $teams = Team::orderBy('name')->get();

        return view('admin.teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new team member.
     */
    public function create()
    {
        return view('admin.teams.form');
    }

    /**
     * Store a newly created team member.
     */
    public function store(Request $request)
    {
        // ✅ Validation first
        $data = $this->validatedData($request);

        try {
            $team = Team::create($data);

            SystemLogger::log(
                'Team member created',
                'info',
                'teams.store',
                [
                    'team_id' => $team->id,
                    'slug' => $team->slug,
                    'email' => $request->email,
                ]
            );

            return redirect()
                ->route('teams.index')
                ->with('success', 'Team member created successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Team creation failed',
                'error',
                'teams.store',
                [
                    'exception' => $e->getMessage(),
                    'email' => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to create team member.');
        }
    }

    /**
     * Show the form for editing the specified team member.
     */
    public function edit(Team $team)
    {
        return view('admin.teams.form', compact('team'));
    }

    /**
     * Update the specified team member.
     */
    public function update(Request $request, Team $team)
    {
        // ✅ Validation first
        $data = $this->validatedData($request);

        try {
            $team->update($data);

            SystemLogger::log(
                'Team member updated',
                'info',
                'teams.update',
                [
                    'team_id' => $team->id,
                    'slug' => $team->slug,
                    'email' => $request->email,
                ]
            );

            return redirect()
                ->route('teams.index')
                ->with('success', 'Team member updated successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Team update failed',
                'error',
                'teams.update',
                [
                    'team_id' => $team->id,
                    'exception' => $e->getMessage(),
                    'email' => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to update team member.');
        }
    }

    /**
     * Remove the specified team member.
     */
    public function destroy(Team $team)
    {
        try {
            // Cleanup image if exists
            if (!empty($team->image_url)) {
                S3::delete($team->image_url);
            }

            $team->delete();

            SystemLogger::log(
                'Team member deleted',
                'warning',
                'teams.delete',
                [
                    'team_id' => $team->id,
                    'email' => request()->email,
                ]
            );

            return redirect()
                ->route('teams.index')
                ->with('success', 'Team member deleted successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Team deletion failed',
                'error',
                'teams.delete',
                [
                    'team_id' => $team->id,
                    'exception' => $e->getMessage(),
                    'email' => request()->email,
                ]
            );

            return back()
                ->with('error', 'Failed to delete team member.');
        }
    }
}
