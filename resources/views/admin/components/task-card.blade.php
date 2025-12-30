@php
    $isOpen = isset($openTaskId) && $openTaskId == $task->id;
@endphp
<div class="col-md-12 col-lg-12 mb-4">
    <div class="card border border-info h-100">
        <div class="card-header text-info d-flex justify-content-between align-items-center">
            <div class="d-flex flex-wrap justify-content-between align-items-center w-100 gap-2">

                <!-- Left: Task Title -->
                <div class="bg-light border-info px-3 py-2 mb-2 shadow-sm">
                    <h6 class="text-info mb-0 fw-semibold">
                        <i class="fas fa-list-ol me-1"></i> Task: #{{ $task->order ?? $loop->iteration }} -
                        {{ $task->title }}
                    </h6>
                </div>

                <!-- Right: Action Buttons -->
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <a href="{{ url('/task/' . $task->id) }}" class="text-primary" title="View Task">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ url('/task/' . $task->id . '/edit') }}" class="text-warning" title="Edit Task">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="#" class="text-danger" title="Delete Task"
                        onclick="event.preventDefault(); if(confirm('Confirm delete?')) document.getElementById('delete-task-{{ $task->id }}').submit();">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                    <form id="delete-task-{{ $task->id }}" method="POST" action="{{ url('/task/' . $task->id) }}"
                        style="display: none;">@csrf @method('DELETE')</form>

                    <a href="{{ url('/task/' . $task->id . '/lessons/create') }}"
                        class="btn btn-sm btn-light border border-success text-success d-flex align-items-center gap-1"
                        title="Add Lesson">
                        <i class="fas fa-chalkboard-teacher"></i><span>Lesson</span>
                    </a>
                    <a href="{{ url('/task/' . $task->id . '/files/create') }}"
                        class="btn btn-sm btn-light border border-info text-info d-flex align-items-center gap-1"
                        title="Add Media">
                        <i class="fas fa-play-circle"></i><span>Media</span>
                    </a>
                    <a href="{{ url('/task/' . $task->id . '/tests/create') }}"
                        class="btn btn-sm btn-light border border-warning text-warning d-flex align-items-center gap-1"
                        title="Add Test">
                        <i class="fas fa-vial"></i><span>Test</span>
                    </a>
                    @php
                        $isOpen = isset($openTaskId) && $openTaskId == $task->id;
                    @endphp
                    @if($task->lessons->count() || $task->files->count() || $task->tests->count())
                        <button class="btn btn-sm btn-light" onclick="toggleCard(this)">
                            <i class="fas {{ $isOpen ? 'fa-chevron-up' : 'fa-chevron-down' }}"></i>
                        </button>
                    @endif


                </div>
            </div>
        </div>
        <div class="card-body border-top collapse-resource" style="{{ $isOpen ? '' : 'display: none;' }}">
            @include('admin.components.resource-list', ['task' => $task])
        </div>
    </div>
</div>