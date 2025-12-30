@php
    $isOpen = isset($openModuleId) && $openModuleId == $module->id;
@endphp
<div class="col-md-12 col-lg-12 mb-4">
    <div class="card border border-secondary h-100">
        <div class="card-header text-primary d-flex justify-content-between align-items-center">

            <div class="d-flex flex-wrap justify-content-between align-items-center w-100 gap-2">

                <!-- Left: Course Title -->
                <div class="bg-light border-primary px-3 py-2 mb-2 shadow-sm">
                    <h5 class="text-secondary mb-0 fw-semibold">
                        <i class="fas fa-cubes me-3"></i>
                        Module: #{{ $module->order ?? $loop->iteration }} - {{ $module->title }}
                    </h5>
                </div>

                <!-- Right: Action Buttons -->
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <!-- View Module -->
                    <a href="{{ url('/module/' . $module->id) }}" class="text-primary" title="View Module">
                        <i class="fas fa-eye"></i>
                    </a>

                    <!-- Edit Module -->
                    <a href="{{ url('/module/' . $module->id . '/edit') }}" class="text-warning" title="Edit Module">
                        <i class="fas fa-edit"></i>
                    </a>

                    <!-- Delete Module -->
                    <a href="#" class="text-danger" title="Delete Module"
                        onclick="event.preventDefault(); if(confirm('Confirm delete?')) document.getElementById('delete-module-{{ $module->id }}').submit();">
                        <i class="fas fa-trash-alt"></i>
                    </a>

                    <form id="delete-module-{{ $module->id }}" method="POST"
                        action="{{ url('/module/' . $module->id) }}" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>

                    <!-- Add Task -->
                    <a href="{{ url('/module/' . $module->id . '/tasks/create') }}"
                        class="btn btn-sm btn-outline-secondary" title="Add Task">
                        <i class="fas fa-plus"></i> Add Task
                    </a>

                </div>

            </div>

            @if($course->modules->count())
                <button class="btn btn-sm btn-light" onclick="toggleCard(this)">
                    <i class="fas fa-chevron-down"></i>
                </button>
            @endif
        </div>

        @if($module->tasks->count())
            <div class="card-body border-top" style="{{ $isOpen ? '' : 'display: none;' }}">
                @foreach($module->tasks as $task)
                    @include('admin.components.task-card', [
                        'task' => $task,
                        'loop' => $loop,
                        'openTaskId' => $openTaskId,
                        'openModuleId' => $openModuleId,
                        'openCourseId' => $openCourseId
                    ])
                @endforeach
                                                                                            </div>
        @endif
    </div>
</div>