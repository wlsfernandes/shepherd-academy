@extends('admin.layouts.master')

@section('title', 'Menu Items')

@section('content')
    <div class="card border border-primary">
        <div class="card-header d-flex justify-content-between">
            <h5>
                <i class="fas fa-bars"></i> Menu Items
            </h5>

            <a href="{{ route('menu-items.create') }}" class="btn btn-success">
                <i class="uil-plus"></i> Add Menu Item
            </a>
        </div>

        <div class="card-body">
            <x-alert />

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Label (EN)</th>
                        <th>URL</th>
                        <th>Order</th>
                        <th>Active</th>
                        <th>New Tab</th>
                        <th width="140">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($menuItems as $item)
                        <tr>
                            {{-- Label --}}
                            <td>
                                <strong>{{ $item->label_en }}</strong>
                                @if($item->label_es)
                                    <br>
                                    <small class="text-muted">{{ $item->label_es }}</small>
                                @endif
                            </td>

                            {{-- URL --}}
                            <td>
                                <code>{{ $item->url }}</code>
                            </td>

                            {{-- Order --}}
                            <td class="text-center">
                                {{ $item->order }}
                            </td>

                            {{-- Active --}}
                            <td class="text-center">
                                <span class="badge {{ $item->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $item->is_active ? 'Yes' : 'No' }}
                                </span>
                            </td>

                            {{-- New Tab --}}
                            <td class="text-center">
                                <span class="badge {{ $item->open_in_new_tab ? 'bg-info' : 'bg-light text-dark' }}">
                                    {{ $item->open_in_new_tab ? 'Yes' : 'No' }}
                                </span>
                            </td>

                            {{-- Actions --}}
                            <td>
                                <a href="{{ route('menu-items.edit', $item) }}" class="btn btn-sm btn-warning">
                                    <i class="uil-pen"></i>
                                </a>

                                <form action="{{ route('menu-items.destroy', $item) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Delete this menu item?')">
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
                                No menu items found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <small class="text-muted d-block mt-3">
                <i class="fas fa-info-circle"></i>
                Menu items control the main website navigation and can link to internal or external pages.
            </small>
        </div>
    </div>
@endsection