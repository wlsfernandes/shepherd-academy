@php
    $isOpen = isset($openCourseId) && $openCourseId == $course->id;
@endphp
<div class="col-md-12 col-lg-12 mb-4">
    <div class="card border border-primary h-100">
        <div class="card-header text-secondary d-flex justify-content-between align-items-center">

            <div class="d-flex flex-wrap justify-content-between align-items-center w-100 gap-2">

                <!-- Left: Course Title -->
                <div class="flex-shrink-0" style="width:160px;height:160px;border-radius:8px;overflow:hidden;
                    background:#f1f3f5;border:1px solid #dee2e6;
                    display:flex;align-items:center;justify-content:center;">

                    @if($course->image_url)
                        <a href="{{ route('admin.images.edit', ['model' => 'course', 'id' => $course->id]) }}"
                            title="Upload / Edit image"><img
                                src="{{ route('admin.images.preview', ['model' => 'course', 'id' => $course->id]) }}"
                                alt="Course image" style="width:100%;height:100%;object-fit:cover;"></a>
                    @else
                        <a href="{{ route('admin.images.edit', ['model' => 'course', 'id' => $course->id]) }}"
                            title="Upload / Edit image">
                            <i class="uil uil-image {{ $course->image_url ? 'text-primary' : 'text-muted' }} font-size-16">Upload
                            </i>
                        </a>
                    @endif
                </div>

                {{-- Course Title --}}
                <div class="flex-grow-1">
                    <h5 class="mb-1 fw-bold text-primary">
                        <i class="fas fa-graduation-cap me-1 text-primary"></i>
                        {{ $course->title }}
                    </h5>
                    @if($course->start_date)
                        <div class="text-muted small mt-1">
                            <strong>Start:</strong> {{ $course->start_date->format('M d, Y') }} <br />
                            <strong>End:</strong> {{ $course->end_date->format('M d, Y') }}
                        </div>
                    @endif
                </div>

                <!-- Right: Action Buttons -->
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <div style="height: 22px; width: 1px; background: #e5e7eb;"></div>
                    @if ($course->is_published)
                        <span class="badge bg-success">Published</span>
                    @else
                        <span class="badge bg-secondary">Unpublished</span>
                    @endif
                    <div style="height: 22px; width: 1px; background: #e5e7eb;"></div>
                    @if ($course->price > 0)
                        <i class="uil uil-dollar-sign text-info"><span class="badge bg-info">{{ $course->price }}</span></i>
                    @else
                        <span class="badge bg-secondary">Free</span>
                    @endif
                    <div style="height: 22px; width: 1px; background: #e5e7eb;"></div>
                    @if($course->allow_installments)
                        <i class="uil uil-calculator text-warning"><span
                                class="badge bg-warning">{{ $course->installment_count }} Installments</span></i>
                    @else
                        <span class="badge bg-secondary">No Installments</span>
                    @endif
                    <div style="height: 22px; width: 1px; background: #e5e7eb;"></div>

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