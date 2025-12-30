<div class="card border border-muted" style="margin:10px;">
    {{-- Lessons --}}
    @if($task->lessons->count())
        <div class="card-header bg-white rounded px-2 py-1 mb-1 shadow-sm py-2 px-3">
            @foreach($task->lessons as $lesson)
                <div
                    class="d-flex justify-content-between align-items-center small mb-1 ms-3 px-3 py-2 shadow-sm border-start border-3 border-success bg-white rounded">
                    <div class="d-flex align-items-center text-dark">
                        <strong>Lesson #{{ $loop->iteration }}: </strong> {{ Str::limit($lesson->title, 40) }}
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ url('/lesson/' . $lesson->id) }}" title="View" class="text-primary"><i
                                class="fas fa-eye"></i></a>
                        <a href="{{ url('/lesson/' . $lesson->id . '/edit') }}" title="Edit" class="text-warning"><i
                                class="fas fa-edit"></i></a>
                        <a href="#" title="Delete" class="text-danger"
                            onclick="event.preventDefault(); if(confirm('Confirm delete?')) document.getElementById('delete-form-lesson-{{ $lesson->id }}').submit();">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                        <form id="delete-form-lesson-{{ $lesson->id }}" action="{{ url('/lesson/' . $lesson->id) }}"
                            method="POST" class="d-none">
                            @csrf @method('DELETE')
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Files --}}
    @if($task->files->count())
        <div class="card-header bg-white rounded px-2 py-1 mb-1 shadow-sm py-2 px-3">
            @foreach($task->files as $file)
                <div
                    class="d-flex justify-content-between align-items-center small mb-1 ms-3 px-3 py-2 shadow-sm border-start border-3 border-info bg-white rounded">
                    <div class="d-flex align-items-center text-dark">
                        <strong>File #{{ $loop->iteration }}: </strong> {{ Str::limit($file->title, 40) }}
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ url('/file/display/' . $file->id) }}" class="text-primary" title="View" target="_blank"><i
                                class="fas fa-eye"></i></a>
                        <a href="{{ url('/file/' . $file->id . '/edit') }}" class="text-warning" title="Edit"><i
                                class="fas fa-edit"></i></a>
                        <a href="#" class="text-danger" title="Delete"
                            onclick="event.preventDefault(); if(confirm('Confirm delete?')) document.getElementById('delete-form-file-{{ $file->id }}').submit();">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                        <form id="delete-form-file-{{ $file->id }}" method="POST" action="{{ url('/file/' . $file->id) }}"
                            class="d-none">
                            @csrf @method('DELETE')
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Tests --}}
    @if($task->tests->count())
        <div class="card-header bg-white rounded px-2 py-1 mb-1 shadow-sm py-2 px-3">
            @foreach($task->tests as $test)
                <div
                    class="d-flex justify-content-between align-items-center small mb-1 ms-3 px-3 py-2 shadow-sm border-start border-3 border-warning bg-white rounded">
                    <div class="d-flex align-items-center text-dark">
                        <strong>Test #{{ $loop->iteration }}: </strong> {{ Str::limit($test->title, 40) }}
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ url('/test/' . $test->id) }}" class="text-primary" title="View"><i
                                class="fas fa-eye"></i></a>
                        <a href="{{ url('/test/' . $test->id . '/edit') }}" class="text-warning" title="Edit"><i
                                class="fas fa-edit"></i></a>
                        <a href="#" class="text-danger" title="Delete"
                            onclick="event.preventDefault(); if(confirm('Confirm delete?')) document.getElementById('delete-form-test-{{ $test->id }}').submit();">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                        <form id="delete-form-test-{{ $test->id }}" method="POST" action="{{ url('/test/' . $test->id) }}"
                            class="d-none">
                            @csrf @method('DELETE')
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>