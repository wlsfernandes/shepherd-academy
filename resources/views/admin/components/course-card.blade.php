@php
    $isOpen = isset($openCourseId) && $openCourseId == $course->id;
@endphp
<div class="col-md-12 col-lg-12 mb-4">
    <div class="card border border-primary h-100">
        <div class="card-header text-secondary d-flex justify-content-between align-items-center">

            <div class="d-flex flex-wrap justify-content-between align-items-center w-100 gap-2">

                <!-- Left: Course Title -->
                <div class="p-3 mb-4 border-start border-5 border-primary bg-light-subtle rounded">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="fas fa-graduation-cap me-1 text-primary"></i>
                        Course: #{{ $course->id }} - {{ $course->title }}
                    </h5>
                </div>


                <!-- Right: Action Buttons -->
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <div style="height: 22px; width: 1px; background: #e5e7eb;"></div>
                    <div class="d-inline-flex align-items-center px-2 py-1 rounded border bg-light gap-2">
                        <a href="{{ route('admin.images.edit', ['model' => 'course', 'id' => $course->id]) }}"
                            title="Upload / Edit image">
                            <i
                                class="uil uil-image {{ $course->image_url ? 'text-primary' : 'text-muted' }} font-size-20"></i>
                        </a>

                        @if($course->image_url)
                            <a href="{{ route('admin.images.preview', ['model' => 'course', 'id' => $course->id]) }}"
                                target="_blank" title="View image">
                                <i class="uil uil-download-alt text-primary"></i>
                            </a>
                        @else
                            <i class="uil uil-download-alt text-muted"></i>
                        @endif
                    </div>
                    <div style="height: 22px; width: 1px; background: #e5e7eb;"></div>
                    <a href="{{ url('/course/' . $course->id) }}" class="text-primary" title="View Course">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ url('/course/' . $course->id . '/edit') }}" class="text-warning" title="Edit Course">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="#" class="text-danger" title="Delete Course"
                        onclick="event.preventDefault(); if(confirm('Confirm delete?')) document.getElementById('delete-form-{{ $course->id }}').submit();">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                    <form id="delete-form-{{ $course->id }}" method="POST" action="{{ url('/course/' . $course->id) }}"
                        style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                    <a href="{{ url('/course/' . $course->id . '/modules/create') }}"
                        class="btn btn-sm btn-outline-primary" title="Add Module">
                        <i class="fas fa-plus"></i> Add Module
                    </a>
                </div>

            </div>

            @if($course->modules->count())
                <button class="btn btn-sm btn-light" onclick="toggleCard(this)">
                    <i class="fas fa-chevron-down"></i>
                </button>
            @endif
        </div>

        @if($course->modules->count())
            <div class="card-body border-top" style="{{ $isOpen ? '' : 'display: none;' }}">
                @foreach($course->modules as $module)
                    @include('admin.components.module-card', [
                        'module' => $module,
                        'openTaskId' => $openTaskId,
                        'openModuleId' => $openModuleId,
                        'openCourseId' => $openCourseId
                    ])
                @endforeach
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>
        @endif
    </div>
</div>