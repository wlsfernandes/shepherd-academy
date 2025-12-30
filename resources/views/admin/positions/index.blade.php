@extends('admin.layouts.master')

@section('title', 'Open Positions')

@section('content')
<div class="card border border-primary">
    <div class="card-header d-flex justify-content-between">
        <h5>
            <i class="fas fa-briefcase"></i> Open Positions
        </h5>

        <a href="{{ route('positions.create') }}" class="btn btn-success">
            <i class="uil-plus"></i> Add Position
        </a>
    </div>

    <div class="card-body">
        <x-alert />

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title (EN)</th>
                    <th>Image</th>
                    <th>File EN</th>
                    <th>File ES</th>
                    <th>Published</th>
                    <th>Publication Window</th>
                    <th width="140">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($positions as $position)
                <tr>
                    {{-- Title --}}
                    <td>
                        <strong>{{ $position->title_en }}</strong><br>
                        <small class="text-muted">
                            {{ $position->title_es ?? '-' }}
                        </small>
                    </td>

                    {{-- Image --}}
                    <td class="text-center">
                        <a href="{{ route('admin.images.edit', ['model' => 'positions', 'id' => $position->id]) }}"
                            title="Upload / Edit image" class="me-2">
                            <i
                                class="uil-image font-size-22 {{ $position->image_url ? 'text-primary' : 'text-muted' }}"></i>
                        </a>

                        @if($position->image_url)
                        <a href="{{ route('admin.images.preview', ['model' => 'positions', 'id' => $position->id]) }}"
                            title="View image" target="_blank">
                            <i class="fas fa-eye font-size-6 text-primary"></i>
                        </a>
                        @else
                        <i class="fas fa-eye font-size-6 text-muted"></i>
                        @endif
                    </td>

                    {{-- File EN --}}
                    <td class="text-center">
                        <a href="{{ route('admin.files.edit', ['model' => 'positions', 'id' => $position->id, 'lang' => 'en']) }}"
                            title="Upload / Edit English file" class="me-2">
                            <i
                                class="uil-file font-size-22 {{ $position->file_url_en ? 'text-primary' : 'text-muted' }}"></i>
                        </a>

                        @if($position->file_url_en)
                        <a href="{{ route('admin.files.download', ['model' => 'positions', 'id' => $position->id, 'lang' => 'en']) }}"
                            title="Download English file">
                            <i class="fas fa-eye font-size-6 text-primary"></i>
                        </a>
                        @else
                        <i class="fas fa-eye font-size-6 text-muted"></i>
                        @endif
                    </td>

                    {{-- File ES --}}
                    <td class="text-center">
                        <a href="{{ route('admin.files.edit', ['model' => 'positions', 'id' => $position->id, 'lang' => 'es']) }}"
                            title="Upload / Edit Spanish file">
                            <i
                                class="uil-file font-size-22 {{ $position->file_url_es ? 'text-primary' : 'text-muted' }}"></i>
                        </a>

                        @if($position->file_url_es)
                        <a href="{{ route('admin.files.download', ['model' => 'positions', 'id' => $position->id, 'lang' => 'es']) }}"
                            title="Download Spanish file">
                            <i class="fas fa-eye font-size-6 text-primary"></i>
                        </a>
                        @else
                        <i class="fas fa-eye font-size-6 text-muted"></i>
                        @endif
                    </td>

                    {{-- Published --}}
                    <td class="text-center">
                        <form method="POST"
                            action="{{ route('admin.publish.toggle', ['model' => 'positions', 'id' => $position->id]) }}">
                            @csrf
                            @method('PATCH')

                            <button type="submit"
                                class="badge border-0 {{ $position->is_published ? 'bg-success' : 'bg-secondary' }}">
                                {{ $position->is_published ? __('Yes') : __('No') }}
                            </button>
                        </form>
                    </td>

                    {{-- Publication Window --}}
                    <td>
                        <small>
                            From:
                            {{ $position->publish_start_at?->format('M d, Y') ?? '-' }}<br>
                            To:
                            {{ $position->publish_end_at?->format('M d, Y') ?? '-' }}
                        </small>
                    </td>

                    {{-- Actions --}}
                    <td>
                        <a href="{{ route('positions.edit', $position) }}" class="btn btn-sm btn-warning">
                            <i class="uil-pen"></i>
                        </a>

                        <form action="{{ route('positions.destroy', $position) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Delete this position?')">
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
                    <td colspan="7" class="text-center text-muted">
                        No positions found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection