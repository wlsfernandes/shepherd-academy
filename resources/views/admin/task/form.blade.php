@extends('admin.layouts.master')

@section('title', 'Add Task to ' . $module->title)

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

                        <input type="hidden" name="module_id" value="{{ $module->id }}">

                        <x-mb3div label="Task Title" name="title" :value="old('title', $task->title ?? '')" :required="true"
                            :disabled="$isViewing ?? false" />

                        <x-save-button route="course.index" :is-editing="$isEditing ?? false"
                            :is-viewing="$isViewing ?? false" />
                    </form>
                </div>
            </div>
        </div>
@endsection