@extends('admin.layouts.master')

@section('title', isset($page) ? 'Edit Page' : 'Create Page')

@section('content')
    <div class="card border border-primary">
        <div class="card-header">
            <h5>
                <i class="fas fa-file-alt"></i>
                {{ isset($page) ? 'Edit Page' : 'Create Page' }}
            </h5>
        </div>

        <div class="card-body">
            <x-alert />

            {{-- Helper block --}}
            <div class="bg-info bg-opacity-10 text-info small p-3 rounded mb-4">
                <span class="text-primary fw-semibold">How pages work:</span><br>
                • The <span class="text-dark">English title</span> generates the public URL (slug).<br>
                • Each page can have a <span class="text-dark">banner image</span> shown at the top.<br>
                • Content supports <span class="text-info">basic formatting</span> (bold, lists, links).<br>
                • Use the <span class="text-success">Publish switch</span> to control visibility.<br>
                • Pages are evergreen — no dates required.
            </div>

            <hr />

            <form method="POST" action="{{ isset($page) ? route('pages.update', $page) : route('pages.store') }}">
                @csrf
                @isset($page)
                    @method('PUT')
                @endisset

                {{-- =======================
                Publish Controls
                ======================== --}}
                <div class="form-check form-switch form-switch-lg mb-4">
                    <input type="checkbox" name="is_published" value="1" class="form-check-input" id="is_published" {{ old('is_published', $page->is_published ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_published">
                        Publish this page on the website
                    </label>
                </div>

                <hr>

                {{-- =======================
                Titles
                ======================== --}}
                <div class="mb-3">
                    <input type="text" name="title_en" class="form-control @error('title_en') is-invalid @enderror"
                        placeholder="Page title in English" value="{{ old('title_en', $page->title_en ?? '') }}" required>

                    <small class="text-muted">
                        Required. Used to generate the public URL.
                    </small>

                    @error('title_en')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <input type="text" name="title_es" class="form-control" placeholder="Título de la página en español"
                        value="{{ old('title_es', $page->title_es ?? '') }}">
                    <small class="text-muted">
                        Optional Spanish version.
                    </small>
                </div>

                @isset($page)
                    <div class="mb-3">
                        <input type="text" class="form-control" value="{{ $page->slug }}" readonly>
                        <small class="text-muted">
                            Public page URL slug (auto-generated).
                        </small>
                    </div>
                @endisset

                <hr>

                {{-- =======================
                Content
                ======================== --}}
                <div class="mb-3">
                    <textarea class="form-control" id="content_en" name="content_en" rows="6"
                        placeholder="Write the page content in English...">{{ old('content_en', $page->content_en ?? '') }}</textarea>
                    <small class="text-muted">
                        Main content shown on the public page.
                    </small>
                </div>

                <div class="mb-3">
                    <textarea class="form-control" id="content_es" name="content_es" rows="6"
                        placeholder="Escriba el contenido de la página en español...">{{ old('content_es', $page->content_es ?? '') }}</textarea>
                    <small class="text-muted">
                        Optional Spanish version.
                    </small>
                </div>

                <hr>

                {{-- =======================
                Actions
                ======================== --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('pages.index') }}" class="btn btn-secondary">
                        <i class="uil-arrow-left"></i> Back
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="uil-save"></i>
                        {{ isset($page) ? 'Update Page' : 'Create Page' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('/assets/admin/libs/ckeditor/ckeditor.min.js') }}"></script>

    <script>
        function createSimpleEditor(selector) {
            ClassicEditor
                .create(document.querySelector(selector), {
                    removePlugins: [
                        'Image',
                        'ImageToolbar',
                        'ImageCaption',
                        'ImageStyle',
                        'ImageUpload',
                        'MediaEmbed'
                    ],
                    toolbar: [
                        'heading', '|',
                        'bold', 'italic', 'link',
                        'bulletedList', 'numberedList', 'blockQuote', '|',
                        'undo', 'redo'
                    ]
                })
                .catch(error => console.error(error));
        }

        createSimpleEditor('#content_en');
        createSimpleEditor('#content_es');
    </script>
@endsection