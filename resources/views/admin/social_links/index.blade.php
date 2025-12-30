@extends('admin.layouts.master')

@section('title', 'Social Media Links')

@section('content')
    <div class="card border border-primary">
        <div class="card-header d-flex justify-content-between">
            <h5>
                <i class="fas fa-share-alt"></i> Social Media Links
            </h5>

            <a href="{{ route('social-links.create') }}" class="btn btn-success">
                <i class="uil-plus"></i> Add Social Link
            </a>
        </div>

        <div class="card-body">
            <x-alert />

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Platform</th>
                        <th>URL</th>
                        <th>Order</th>
                        <th>Active</th>
                        <th width="140">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($socialLinks as $link)
                        <tr>
                            {{-- Platform --}}
                            <td>
                                <i class="{{ $link->icon() }} me-1"></i>
                                {{ $link->label() }}
                            </td>

                            {{-- URL --}}
                            <td>
                                <a href="{{ $link->url }}" target="_blank">
                                    {{ Str::limit($link->url, 40) }}
                                </a>
                            </td>

                            {{-- Order --}}
                            <td class="text-center">
                                {{ $link->order }}
                            </td>

                            {{-- Active --}}
                            <td class="text-center">
                                <form method="POST"
                                    action="{{ route('admin.publish.toggle', ['model' => Str::snake(class_basename($link)), 'id' => $link->id]) }}">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                        class="badge border-0 {{ $link->is_published ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $link->is_published ? __('Yes') : __('No') }}
                                    </button>
                                </form>
                            </td>

                            {{-- Actions --}}
                            <td>
                                <a href="{{ route('social-links.edit', $link) }}" class="btn btn-sm btn-warning">
                                    <i class="uil-pen"></i>
                                </a>

                                <form action="{{ route('social-links.destroy', $link) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Delete this social link?')">
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
                                No social media links found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <small class="text-muted d-block mt-3">
                <i class="fas fa-info-circle"></i>
                These links appear globally on the website (header, footer, or social sections).
            </small>
        </div>
    </div>
@endsection