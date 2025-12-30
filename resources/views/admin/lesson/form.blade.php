@extends('admin.layouts.master')

@section('title', 'Add Task to ' . $task->title)

@section('css')
    <!-- plugin css -->
    <link href="{{ asset('/assets/admin/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/admin/libs/spectrum-colorpicker/spectrum-colorpicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/admin/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/admin/libs/bootstrap-touchspin/bootstrap-touchspin.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/assets/admin/libs/datepicker/datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/admin/libs/flatpickr/flatpickr.min.css') }}">
@endsection


@section('content')
    <x-back-button route="course.index" />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <x-alert />
                <div class="card-body">
                    <form action="{{ $formAction ?? '#' }}" method="POST">
                        @csrf
                        @if (($formMethod ?? '') === 'PUT') @method('PUT') @endif

                        <input type="hidden" name="task_id" value="{{ $task->id }}">

                        <x-mb3div label="Lesson Title" name="title" :value="old('title', $lesson->title ?? '')"
                            :required="true" />

                        <div class="mb-3 row">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Class Content: <small>Insert here html content</small></h4>
                                    <div id="content">{!! $lesson->content ?? '' !!}</div>
                                    <textarea style="display:none;width: 100%; height: 300px; font-size: 1.1rem;"
                                        name="content"
                                        id="text_content">{{ old('content', $lesson->content ?? '') }}</textarea>
                                    <p class="form-text text-muted">
                                        Provide a brief summary of the post in English. Keep it concise and informative.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <x-save-button route="course.index" :is-editing="$isEditing ?? false"
                            :is-viewing="$isViewing ?? false" />
                    </form>
                </div>
            </div>
        </div>
@endsection
    @section('script')
        <script src="{{ asset('/assets/admin/libs/ckeditor/ckeditor.min.js') }}"></script>
        <script src="{{ asset('/assets/admin/libs/tinymce/tinymce.min.js') }}"></script>
        <script src="{{ asset('/assets/admin/js/pages/form-editor.init.js') }}"></script>
        <script>
            function createSimpleEditor(selector, hiddenInputId) {
                ClassicEditor
                    .create(document.querySelector(selector), {
                        removePlugins: ['Image', 'ImageToolbar', 'ImageCaption', 'ImageStyle', 'ImageUpload', 'MediaEmbed'],
                        toolbar: [
                            'heading', '|',
                            'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
                            'undo', 'redo'
                        ]
                    })
                    .then(editor => {
                        editor.model.document.on('change', () => {
                            document.querySelector(hiddenInputId).value = editor.getData();
                        });
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }

            createSimpleEditor('#content', '#text_content');
        </script>
    @endsection