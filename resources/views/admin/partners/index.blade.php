@extends('admin.layouts.master')

@section('title', 'Partners')

@section('content')
    <div class="card border border-primary">
        <div class="card-header d-flex justify-content-between">
            <h5>
                <i class="fas fa-handshake"></i> Partners
            </h5>

            <a href="{{ route('partners.create') }}" class="btn btn-success">
                <i class="uil-plus"></i> Add Partner
            </a>
        </div>

        <div class="card-body">
            <x-alert />

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Logo</th>
                        <th>External Link</th>
                        <th>Published</th>
                        <th width="140">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($partners as $partner)
                        <tr>
                            {{-- Name --}}
                            <td>
                                {{ $partner->name ?? '-' }}
                            </td>

                            {{-- Image --}}
                            <td class="text-center">
                                <a href="{{ route('admin.images.edit', ['model' => 'partners', 'id' => $partner->id]) }}"
                                    title="Upload / Edit logo" class="me-2">
                                    <i
                                        class="uil-image font-size-22 {{ $partner->image_url ? 'text-primary' : 'text-muted' }}"></i>
                                </a>

                                @if($partner->image_url)
                                    <a href="{{ route('admin.images.preview', ['model' => 'partners', 'id' => $partner->id]) }}"
                                        title="View logo" target="_blank">
                                        <i class="fas fa-eye font-size-6 text-primary"></i>
                                    </a>
                                @else
                                    <i class="fas fa-eye font-size-6 text-muted"></i>
                                @endif
                            </td>

                            {{-- External Link --}}
                            <td class="text-center">
                                @if($partner->external_link)
                                    <a href="{{ $partner->external_link }}" target="_blank" class="text-primary"
                                        title="Visit partner website">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            {{-- Published --}}
                            <td class="text-center">
                                <form method="POST"
                                    action="{{ route('admin.publish.toggle', ['model' => 'partners', 'id' => $partner->id]) }}">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                        class="badge border-0 {{ $partner->is_published ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $partner->is_published ? __('Yes') : __('No') }}
                                    </button>
                                </form>
                            </td>

                            {{-- Actions --}}
                            <td>
                                <a href="{{ route('partners.edit', $partner) }}" class="btn btn-sm btn-warning">
                                    <i class="uil-pen"></i>
                                </a>

                                <form action="{{ route('partners.destroy', $partner) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Delete this partner?')">
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
                                No partners found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection