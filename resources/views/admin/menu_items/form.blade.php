@extends('admin.layouts.master')

@section('title', isset($menuItem) ? 'Edit Menu Item' : 'Create Menu Item')

@section('content')
    <div class="card border border-primary">
        <div class="card-header">
            <h5>
                <i class="fas fa-bars"></i>
                {{ isset($menuItem) ? 'Edit Menu Item' : 'Create Menu Item' }}
            </h5>
        </div>

        <div class="card-body">
            <x-alert />

            {{-- Helper --}}
            <div class="bg-info bg-opacity-10 text-info small p-3 rounded mb-4">
                <i class="fas fa-info-circle"></i>
                Menu items control the website navigation. You can link to internal pages
                (e.g. <code>/about</code>) or external websites.
            </div>

            <form method="POST"
                action="{{ isset($menuItem) ? route('menu-items.update', $menuItem) : route('menu-items.store') }}">
                @csrf
                @isset($menuItem)
                    @method('PUT')
                @endisset

                {{-- =======================
                Labels
                ======================== --}}
                <h6 class="text-primary mb-3">Menu Labels</h6>

                <div class="mb-3">
                    <label class="form-label">Label (English)</label>
                    <input type="text" name="label_en" class="form-control @error('label_en') is-invalid @enderror"
                        placeholder="Example: About Us" value="{{ old('label_en', $menuItem->label_en ?? '') }}" required>

                    @error('label_en')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    <small class="text-muted">
                        Main label shown in the navigation menu.
                    </small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Label (Spanish)</label>
                    <input type="text" name="label_es" class="form-control" placeholder="Ejemplo: Sobre Nosotros"
                        value="{{ old('label_es', $menuItem->label_es ?? '') }}">

                    <small class="text-muted">
                        Optional Spanish translation.
                    </small>
                </div>

                <hr>

                {{-- =======================
                URL
                ======================== --}}
                <h6 class="text-primary mb-3">Link</h6>

                <div class="mb-3">
                    <label class="form-label">URL</label>
                    <input type="text" name="url" class="form-control @error('url') is-invalid @enderror"
                        placeholder="/about  or  https://external-site.com" value="{{ old('url', $menuItem->url ?? '') }}"
                        required>

                    @error('url')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    <small class="text-muted">
                        For internal pages, use the page URL (for example: <code>/about</code>).
                        You can find this value by going to <strong>Pages</strong> and copying the
                        page <strong>slug</strong>. For external websites, use the full URL.
                    </small>
                </div>


                <div class="form-check form-switch form-switch-lg mb-4">
                    <input type="checkbox" name="open_in_new_tab" value="1" class="form-check-input" id="open_in_new_tab" {{ old('open_in_new_tab', $menuItem->open_in_new_tab ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="open_in_new_tab">
                        Open link in a new tab
                    </label>
                </div>

                <hr>

                {{-- =======================
                Display Options
                ======================== --}}
                <h6 class="text-primary mb-3">Display Options</h6>

                <div class="mb-3">
                    <label class="form-label">Display Order</label>
                    <input type="number" name="order" class="form-control" placeholder="0"
                        value="{{ old('order', $menuItem->order ?? 0) }}">

                    <small class="text-muted">
                        Lower numbers appear first in the navigation.
                    </small>
                </div>

                <div class="form-check form-switch form-switch-lg mb-4">
                    <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" {{ old('is_active', $menuItem->is_active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">
                        Show this menu item on the website
                    </label>
                </div>

                <hr>

                {{-- =======================
                Actions
                ======================== --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('menu-items.index') }}" class="btn btn-secondary">
                        <i class="uil-arrow-left"></i> Back
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="uil-save"></i>
                        {{ isset($menuItem) ? 'Update Menu Item' : 'Create Menu Item' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection