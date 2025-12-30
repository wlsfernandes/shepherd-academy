@extends('admin.layouts.master')

@section('title', 'Team')

@section('content')
    <div class="card border border-primary">
        <div class="card-header d-flex justify-content-between">
            <h5>
                <i class="fas fa-users"></i> Team
            </h5>

            <a href="{{ route('teams.create') }}" class="btn btn-success">
                <i class="uil-plus"></i> Add Team Member
            </a>
        </div>

        <div class="card-body">
            <x-alert />

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Slug</th>
                        <th>Image</th>
                        <th>Published</th>
                        <th width="140">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($teams as $team)
                        <tr>
                            {{-- Name --}}
                            <td>
                                <strong>{{ $team->name }}</strong>
                            </td>

                            {{-- Role --}}
                            <td>
                                <small class="text-muted">
                                    {{ $team->role ?? '-' }}
                                </small>
                            </td>

                            {{-- Slug --}}
                            <td>
                                <code>{{ $team->slug }}</code>
                            </td>

                            {{-- Image --}}
                            <td class="text-center">
                                <a href="{{ route('admin.images.edit', ['model' => 'teams', 'id' => $team->id]) }}"
                                    title="Upload / Edit image" class="me-2">
                                    <i
                                        class="uil-image font-size-22 {{ $team->image_url ? 'text-primary' : 'text-muted' }}"></i>
                                </a>

                                @if($team->image_url)
                                    <a href="{{ route('admin.images.preview', ['model' => 'teams', 'id' => $team->id]) }}"
                                        title="View image" target="_blank">
                                        <i class="fas fa-eye font-size-6 text-primary"></i>
                                    </a>
                                @else
                                    <i class="fas fa-eye font-size-6 text-muted"></i>
                                @endif
                            </td>

                            {{-- Published --}}
                            <td class="text-center">
                                <form method="POST"
                                    action="{{ route('admin.publish.toggle', ['model' => 'teams', 'id' => $team->id]) }}">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                        class="badge border-0 {{ $team->is_published ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $team->is_published ? __('Yes') : __('No') }}
                                    </button>
                                </form>
                            </td>

                            {{-- Actions --}}
                            <td>
                                <a href="{{ route('teams.edit', $team) }}" class="btn btn-sm btn-warning">
                                    <i class="uil-pen"></i>
                                </a>

                                <form action="{{ route('teams.destroy', $team) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Delete this team member?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-danger">
                                        <i class="uil-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                No team members found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection