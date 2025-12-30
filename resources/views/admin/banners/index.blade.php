@extends('admin.layouts.master')

@section('title', 'Banners')

@section('content')
    <div class="card border border-primary">
        <div class="card-header d-flex justify-content-between">
            <h5>
                <i class="uil-megaphone"></i> Banners
            </h5>
            <a href="{{ route('banners.create') }}" class="btn btn-success">
                <i class="uil-plus"></i> Add Banner
            </a>
        </div>

        <div class="card-body">
            <x-alert />

            <table class="table table-bordered">
                <thead>
                    <tr>

                        <th>Title (EN)</th>
                        <th>Image</th>
                        <th>Link</th>
                        <th>Published</th>
                        <th>Publication Window</th>
                        <th>Order</th>
                        <th width="140">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($banners as $banner)
                                    <tr>

                                        <td>
                                            <strong>{{ $banner->title_en }}</strong>

                                            @if($banner->subtitle_en)
                                                <br>
                                                <small class="text-muted">
                                                    {{ Str::limit($banner->subtitle_en, 60) }}
                                                </small>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.images.edit', ['model' => 'banners', 'id' => $banner->id]) }}"
                                                title="Upload / Edit image" class="me-2">
                                                <i
                                                    class="uil-image font-size-22 {{ $banner->image_url ? 'text-primary' : 'text-muted' }}"></i>
                                            </a>

                                            @if($banner->image_url)
                                                <a href="{{ route('admin.images.preview', ['model' => 'banners', 'id' => $banner->id]) }}"
                                                    title="View image" target="_blank">
                                                    <i class="fas fa-eye font-size-6 text-primary"></i>
                                                </a>
                                            @else
                                                <i class="fas fa-eye font-size-6 text-muted"></i>
                                            @endif
                                        </td>
                                        {{-- External link --}}
                                        <td>
                                            @if($banner->link)
                                                <a href="{{ $banner->link }}" target="{{ $banner->open_in_new_tab ? '_blank' : '_self' }}"
                                                    class="text-primary">
                                                    {{ Str::limit($banner->link, 40) }}
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>

                                        {{-- Publish toggle (generic controller) --}}
                                        <td class="text-center">
                                            <form method="POST" action="{{ route('admin.publish.toggle', [
                            'model' => Str::snake(class_basename($banner)),
                            'id' => $banner->id
                        ]) }}">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                    class="badge border-0 {{ $banner->is_published ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $banner->is_published ? __('Yes') : __('No') }}
                                                </button>
                                            </form>
                                        </td>

                                        {{-- Publication window --}}
                                        <td>
                                            <small>
                                                From:
                                                {{ $banner->publish_start_at?->format('M d, Y') ?? '-' }}<br>
                                                To:
                                                {{ $banner->publish_end_at?->format('M d, Y') ?? '-' }}
                                            </small>
                                        </td>

                                        {{-- Sort order --}}
                                        <td class="text-center">
                                            {{ $banner->sort_order }}
                                        </td>

                                        {{-- Actions --}}
                                        <td>
                                            <a href="{{ route('banners.edit', $banner) }}" class="btn btn-sm btn-warning">
                                                <i class="uil-pen"></i>
                                            </a>

                                            <form action="{{ route('banners.destroy', $banner) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Delete this banner?')">
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
                                No banners found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection