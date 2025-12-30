@extends('admin.layouts.master')

@section('title', 'Resources')

@section('content')
    <div class="card border border-primary">
        <div class="card-header d-flex justify-content-between">
            <h5>
                <i class="fas fa-folder-open"></i> Resources
            </h5>

            <a href="{{ route('resources.create') }}" class="btn btn-success">
                <i class="uil-plus"></i> Add Resource
            </a>
        </div>

        <div class="card-body">
            <x-alert />

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title (EN)</th>
                        <th>File EN</th>
                        <th>File ES</th>
                        <th>External Link</th>
                        <th>Published</th>
                        <th width="140">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($resources as $resource)
                        <tr>
                            {{-- Title --}}
                            <td>
                                <strong>{{ $resource->title_en }}</strong><br>
                                <small class="text-muted">
                                    {{ $resource->title_es ?? '-' }}
                                </small>
                            </td>

                            {{-- File EN --}}
                            <td class="text-center">
                                <a href="{{ route('admin.files.edit', ['model' => 'resources', 'id' => $resource->id, 'lang' => 'en']) }}"
                                    title="Upload / Edit English file" class="me-2">
                                    <i
                                        class="uil-file font-size-22 {{ $resource->file_url_en ? 'text-primary' : 'text-muted' }}"></i>
                                </a>

                                @if($resource->file_url_en)
                                    <a href="{{ route('admin.files.download', ['model' => 'resources', 'id' => $resource->id, 'lang' => 'en']) }}"
                                        title="Download English file">
                                        <i class="fas fa-eye font-size-6 text-primary"></i>
                                    </a>
                                @else
                                    <i class="fas fa-eye font-size-6 text-muted"></i>
                                @endif
                            </td>

                            {{-- File ES --}}
                            <td class="text-center">
                                <a href="{{ route('admin.files.edit', ['model' => 'resources', 'id' => $resource->id, 'lang' => 'es']) }}"
                                    title="Upload / Edit Spanish file">
                                    <i
                                        class="uil-file font-size-22 {{ $resource->file_url_es ? 'text-primary' : 'text-muted' }}"></i>
                                </a>

                                @if($resource->file_url_es)
                                    <a href="{{ route('admin.files.download', ['model' => 'resources', 'id' => $resource->id, 'lang' => 'es']) }}"
                                        title="Download Spanish file">
                                        <i class="fas fa-eye font-size-6 text-primary"></i>
                                    </a>
                                @else
                                    <i class="fas fa-eye font-size-6 text-muted"></i>
                                @endif
                            </td>

                            {{-- External Link --}}
                            <td class="text-center">
                                @if($resource->external_link)
                                    <a href="{{ $resource->external_link }}" target="_blank" title="Open external resource">
                                        <i class="fas fa-external-link-alt text-primary"></i>
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            {{-- Published --}}
                            <td class="text-center">
                                <form method="POST"
                                    action="{{ route('admin.publish.toggle', ['model' => 'resources', 'id' => $resource->id]) }}">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                        class="badge border-0 {{ $resource->is_published ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $resource->is_published ? __('Yes') : __('No') }}
                                    </button>
                                </form>
                            </td>

                            {{-- Actions --}}
                            <td>
                                <a href="{{ route('resources.edit', $resource) }}" class="btn btn-sm btn-warning">
                                    <i class="uil-pen"></i>
                                </a>

                                <form action="{{ route('resources.destroy', $resource) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Delete this resource?')">
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
                                No resources found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection