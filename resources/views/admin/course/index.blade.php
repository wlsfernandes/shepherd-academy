@extends('admin.layouts.master')

@section('title', 'Courses')

@section('content')
    @php
        $openTaskId = session('open_task_id');
        $openModuleId = session('open_module_id');
        $openCourseId = session('open_course_id');
    @endphp

    <div class="row">
        <x-alert />
        <div>
            <a href="{{ url('course/create') }}">
                <button type="button" class="btn btn-success waves-effect waves-light mb-3"><i class="fas fa-plus"></i> Add
                    New</button> </a>
        </div>
        @foreach ($courses as $course)
            @include('admin.components.course-card', ['course' => $course, 'openTaskId' => $openTaskId, 'openModuleId' => $openModuleId, 'openCourseId' => $openCourseId])
        @endforeach
    </div>

@endsection

@push('script')
    <script>
        function toggleCard(button) {
            const section = button.closest('.card').querySelector('.card-body.border-top');
            if (section.style.display === 'none' || section.style.display === '') {
                section.style.display = 'block';
                button.innerHTML = '<i class="fas fa-chevron-up"></i>';
            } else {
                section.style.display = 'none';
                button.innerHTML = '<i class="fas fa-chevron-down"></i>';
            }
        }
    </script>
@endpush