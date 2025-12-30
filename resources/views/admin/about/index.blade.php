@extends('admin.layouts.master')

@section('title', 'About Pages')

@section('content')
    <div class="card border border-primary">
        <div class="card-header d-flex justify-content-between">
            <h5>
                <i class="uil-file-alt"></i> About Us Page
            </h5>

            <a href="{{ route('about.create') }}" class="btn btn-success">
                <i class="uil-plus"></i> Add About Page
            </a>
        </div>

        <div class="card-body">
            <x-alert />

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title (EN)</th>
                        <th>Image</th>
                        <th>Published</th>
                        <th>Publication Window</th>
                        <th width="140">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($abouts as $about)
                        <tr>
                            {{-- Title --}}
                            <td>
                                <strong>{{ $about->title_en }}</strong><br>
                                <small class="text-muted">
                                    {{ $about->subtitle_en ?? '-' }}
                                </small>
                            </td>

                            {{-- Image --}}
                            <td class="text-center">
                                <a href="{{ route('admin.images.edit', ['model' => 'about', 'id' => $about->id]) }}"
                                    title="Upload / Edit image" class="me-2">
                                    <i
                                        class="uil-image font-size-22 {{ $about->image_url ? 'text-primary' : 'text-muted' }}"></i>
                                </a>

                                @if($about->image_url)
                                    <a href="{{ route('admin.images.preview', ['model' => 'about', 'id' => $about->id]) }}"
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
                                    action="{{ route('admin.publish.toggle', ['model' => 'about', 'id' => $about->id]) }}">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                        class="badge border-0 {{ $about->is_published ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $about->is_published ? __('Yes') : __('No') }}
                                    </button>
                                </form>
                            </td>

                            {{-- Publication Window --}}
                            <td>
                                <small>
                                    From:
                                    {{ $about->publish_start_at?->format('M d, Y') ?? '-' }}<br>
                                    To:
                                    {{ $about->publish_end_at?->format('M d, Y') ?? '-' }}
                                </small>
                            </td>

                            {{-- Actions --}}
                            <td>
                                <a href="{{ route('about.edit', $about) }}" class="btn btn-sm btn-warning">
                                    <i class="uil-pen"></i>
                                </a>

                                <form action="{{ route('about.destroy', $about) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Delete this About page?')">
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
                            <td colspan="5" class="text-center text-muted">
                                No About pages found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection