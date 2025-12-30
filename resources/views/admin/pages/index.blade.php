@extends('admin.layouts.master')

@section('title', 'Pages')

@section('content')
    <div class="card border border-primary">
        <div class="card-header d-flex justify-content-between">
            <h5>
                <i class="fas fa-file-alt"></i> Pages
            </h5>

            <a href="{{ route('pages.create') }}" class="btn btn-success">
                <i class="uil-plus"></i> Add Page
            </a>
        </div>

        <div class="card-body">
            <x-alert />

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title (EN)</th>
                        <th>Slug</th>
                        <th>Banner</th>
                        <th>Published</th>
                        <th width="140">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($pages as $page)
                        <tr>
                            {{-- Title --}}
                            <td>
                                <strong>{{ $page->title_en }}</strong><br>
                                <small class="text-muted">
                                    {{ $page->title_es ?? '-' }}
                                </small>
                            </td>

                            {{-- Slug --}}
                            <td>
                                <code>{{ $page->slug }}</code>
                            </td>

                            {{-- Banner Image --}}
                            <td class="text-center">
                                <a href="{{ route('admin.images.edit', ['model' => 'pages', 'id' => $page->id]) }}"
                                    title="Upload / Edit banner image" class="me-2">
                                    <i
                                        class="uil-image font-size-22 {{ $page->image_url ? 'text-primary' : 'text-muted' }}"></i>
                                </a>

                                @if($page->image_url)
                                    <a href="{{ route('admin.images.preview', ['model' => 'pages', 'id' => $page->id]) }}"
                                        title="View banner image" target="_blank">
                                        <i class="fas fa-eye font-size-6 text-primary"></i>
                                    </a>
                                @else
                                    <i class="fas fa-eye font-size-6 text-muted"></i>
                                @endif
                            </td>

                            {{-- Published --}}
                            <td class="text-center">
                                <form method="POST"
                                    action="{{ route('admin.publish.toggle', ['model' => 'pages', 'id' => $page->id]) }}">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                        class="badge border-0 {{ $page->is_published ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $page->is_published ? __('Yes') : __('No') }}
                                    </button>
                                </form>
                            </td>

                            {{-- Actions --}}
                            <td>
                                <a href="{{ route('pages.edit', $page) }}" class="btn btn-sm btn-warning">
                                    <i class="uil-pen"></i>
                                </a>

                                <form action="{{ route('pages.destroy', $page) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Delete this page?')">
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
                                No pages found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection