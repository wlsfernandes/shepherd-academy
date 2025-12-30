@extends('admin.layouts.master')

@section('title', 'Add Module to ' . $course->title)

@section('content')
    <x-back-button route="course.index" />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <x-alert />
                    <form action="{{ $formAction ?? '#' }}" method="POST">
                        @csrf
                        @if (($formMethod ?? '') === 'PUT') @method('PUT') @endif

                        <input type="hidden" name="course_id" value="{{ $course->id }}">

                        <x-mb3div label="Module Title" name="title" :value="old('title', $module->title ?? '')" :required="true"
                            :disabled="$isViewing ?? false" />

                            <x-save-button route="course.index" :is-editing="$isEditing ?? false"
                            :is-viewing="$isViewing ?? false" />
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection