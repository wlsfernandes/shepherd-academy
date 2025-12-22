@extends('admin.layouts.master')

@section('title', 'Testimonials')

@section('content')
    <div class="card border border-primary">
        <div class="card-header d-flex justify-content-between">
            <h5>
                <i class="fas fa-comment-dots"></i> Testimonials
            </h5>

            <a href="{{ route('testimonials.create') }}" class="btn btn-success">
                <i class="uil-plus"></i> Add Testimonial
            </a>
        </div>

        <div class="card-body">
            <x-alert />

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Author</th>
                        <th>Role</th>
                        <th>Content (EN)</th>
                        <th>Image</th>
                        <th>Published</th>
                        <th width="140">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($testimonials as $testimonial)
                        <tr>
                            {{-- Author --}}
                            <td>
                                {{ $testimonial->name ?? '-' }}
                            </td>

                            {{-- Role --}}
                            <td>
                                <small class="text-muted">
                                    {{ $testimonial->role ?? '-' }}
                                </small>
                            </td>

                            {{-- Content --}}
                            <td>
                                <small>
                                    {{ Str::limit(strip_tags($testimonial->content_en), 80) }}
                                </small>
                            </td>

                            {{-- Image --}}
                            <td class="text-center">
                                <a href="{{ route('admin.images.edit', ['model' => 'testimonials', 'id' => $testimonial->id]) }}"
                                    title="Upload / Edit image" class="me-2">
                                    <i
                                        class="uil-image font-size-22 {{ $testimonial->image_url ? 'text-primary' : 'text-muted' }}"></i>
                                </a>

                                @if($testimonial->image_url)
                                    <a href="{{ route('admin.images.preview', ['model' => 'testimonials', 'id' => $testimonial->id]) }}"
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
                                    action="{{ route('admin.publish.toggle', ['model' => 'testimonials', 'id' => $testimonial->id]) }}">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                        class="badge border-0 {{ $testimonial->is_published ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $testimonial->is_published ? __('Yes') : __('No') }}
                                    </button>
                                </form>
                            </td>

                            {{-- Actions --}}
                            <td>
                                <a href="{{ route('testimonials.edit', $testimonial) }}" class="btn btn-sm btn-warning">
                                    <i class="uil-pen"></i>
                                </a>

                                <form action="{{ route('testimonials.destroy', $testimonial) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Delete this testimonial?')">
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
                                No testimonials found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection