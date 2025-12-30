@extends('admin.layouts.master')

@section('title', ($isEditing ?? false) ? 'Edit Course' : (($isViewing ?? false) ? 'View Course' : 'Create Course'))

@section('content')

    <x-back-button route="course.index" />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <x-alert />

                    <form action="{{ $formAction ?? '#' }}" method="POST">
                        @csrf
                        @if (($formMethod ?? '') === 'PUT')
                            @method('PUT')
                        @endif


                        {{-- START / END DATES --}}
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <div class="form-check form-switch form-switch-lg">
                                    <input type="checkbox" name="is_published" value="1" class="form-check-input"
                                        id="is_published" {{ old('is_published', $course->is_published ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_published">
                                        Publish this course on the website
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Course Price (USD)</label>
                                <input type="number" step="0.01" name="price" class="form-control"
                                    value="{{ old('price', $course->price ?? '') }}" {{ ($isViewing ?? false) ? 'disabled' : '' }}>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" class="form-control"
                                    value="{{ old('start_date', $course->start_date ?? '') }}" {{ ($isViewing ?? false) ? 'disabled' : '' }}>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">End Date</label>
                                <input type="date" name="end_date" class="form-control"
                                    value="{{ old('end_date', $course->end_date ?? '') }}" {{ ($isViewing ?? false) ? 'disabled' : '' }}>
                            </div>
                        </div>

                        {{-- PUBLISH --}}

                        {{-- COURSE TITLE --}}
                        <div class="mb-3">
                            <label class="form-label">Course Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control"
                                value="{{ old('title', $course->title ?? '') }}" {{ ($isViewing ?? false) ? 'disabled' : '' }} required>
                        </div>

                        {{-- SUMMARY --}}
                        <div class="mb-3">
                            <label class="form-label">Short Summary</label>
                            <textarea id="summary" name="summary" class="form-control" rows="3" {{ ($isViewing ?? false) ? 'disabled' : '' }}>{{ old('summary', $course->summary ?? '') }}</textarea>
                            <small class="text-muted">
                                Short public description shown in the course catalog.
                            </small>
                        </div>

                        {{-- DESCRIPTION --}}
                        <div class="mb-3">
                            <label class="form-label">Full Description</label>
                            <textarea id="description" name="description" class="form-control" rows="6" {{ ($isViewing ?? false) ? 'disabled' : '' }}>{{ old('description', $course->description ?? '') }}</textarea>
                        </div>

                        {{-- PRICE --}}


                        {{-- ACTION BUTTONS --}}
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('course.index') }}" class="btn btn-secondary">
                                Back
                            </a>

                            @if (!($isViewing ?? false))
                                <button type="submit" class="btn btn-primary">
                                    {{ ($isEditing ?? false) ? 'Update Course' : 'Create Course' }}
                                </button>
                            @endif
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ asset('/assets/admin/libs/ckeditor/ckeditor.min.js') }}"></script>

    <script>
        function createSimpleEditor(selector) {
            const element = document.querySelector(selector);
            if (!element || element.hasAttribute('disabled')) return;

            ClassicEditor
                .create(element, {
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
                .catch(error => {
                    console.error(error);
                });
        }

        createSimpleEditor('#summary');
        createSimpleEditor('#description');
    </script>
@endsection