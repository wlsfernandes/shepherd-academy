@extends('admin.layouts.master')

@section('title', 'Add Task to ' . $task->title)

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

                        <x-mb3div label="Test Name" name="title" :value="old('title', $test->title ?? '')"
                            :required="true" />

                        <input type="hidden" id="deleted-questions" name="deleted_questions" value="">

                        <div id="questions-wrapper">
                            @if (isset($test) && $test->questions->count())
                                @foreach ($test->questions as $qIndex => $question)
                                    <input type="hidden" name="questions[{{ $qIndex }}][id]" value="{{ $question->id }}">

                                    <div class="border border-dark rounded p-3 mb-4 bg-light shadow-sm">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-label mb-0"><strong>Question {{ $qIndex + 1 }}</strong></label>
                                            <button type="button" class="btn btn-sm text-danger" title="Delete this question"
                                                onclick="if(confirm('Delete this question?')) document.getElementById('delete-question-{{ $question->id }}').submit();">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>

                                        </div>

                                        <input type="text" name="questions[{{ $qIndex }}][description]"
                                            value="{{ $question->description }}" class="form-control mb-3" required>

                                        <div class="row">
                                            @foreach ($question->options as $oIndex => $option)
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label ">Option {{ $oIndex + 1 }}</label>
                                                    <input type="text" name="questions[{{ $qIndex }}][options][{{ $oIndex }}][text]"
                                                        value="{{ $option->text }}" class="form-control mb-1" required>

                                                    <div class="form-check ">
                                                        <input class="form-check-input" type="radio"
                                                            name="questions[{{ $qIndex }}][correct]" value="{{ $oIndex }}"
                                                            id="question-{{ $qIndex }}-option-{{ $oIndex }}" {{ $option->is_correct ? 'checked' : '' }} required>
                                                        <label class="form-check-label border border-dark rounded px-2 py-1"
                                                            for="question-{{ $qIndex }}-option-{{ $oIndex }}">
                                                            Mark as correct
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <small class="text-muted">
                                            Please mark <strong>only one</strong> correct option. The selected one will be used to
                                            grade this question.
                                        </small>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <x-save-button route="course.index" :is-editing="$isEditing ?? false"
                            :is-viewing="$isViewing ?? false" />


                        <div class="text-center my-4">
                            <button type="button" class="btn btn-success btn-lg" onclick="addQuestion()">
                                <i class="fas fa-plus-circle"></i> Add Question
                            </button>
                        </div>

                    </form>
                    @if(isset($test))
                        @foreach ($test->questions as $question)
                            <form id="delete-question-{{ $question->id }}" action="{{ route('questions.destroy', $question->id) }}"
                                method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endforeach
                    @endif


                </div>
            </div>
        </div>
@endsection
    @push('script')
        <script>
            let questionCount = {{ isset($test) ? $test->questions->count() : 0 }};

            function addQuestion() {
                const wrapper = document.getElementById('questions-wrapper');

                const questionHTML = `
                                                                                                                                                                                                                            <div class="border border-dark rounded p-3 mb-4 bg-light shadow-sm">
                                                                                                                                                                                                                                <label class="form-label"><strong>Question ${questionCount + 1}</strong></label>
                                                                                                                                                                                                                                <input type="text" name="questions[${questionCount}][description]" class="form-control mb-3" required>

                                                                                                                                                                                                                                <div class="row">
                                                                                                                                                                                                                                    ${[0, 1, 2, 3].map(i => `
                                                                                                                                                                                                                                        <div class="col-md-6 mb-3">
                                                                                                                                                                                                                                            <label class="form-label">Option ${i + 1}</label>
                                                                                                                                                                                                                                            <input type="text"
                                                                                                                                                                                                                                                   class="form-control mb-1"
                                                                                                                                                                                                                                                   name="questions[${questionCount}][options][${i}][text]"
                                                                                                                                                                                                                                                   placeholder="Enter option text"
                                                                                                                                                                                                                                                   required>

                                                                                                                                                                                                                                            <div class="form-check">
                                                                                                                                                                                                                                                <input class="form-check-input border border-dark rounded px-2 py-1"
                                                                                                                                                                                                                                                       type="radio"
                                                                                                                                                                                                                                                       name="questions[${questionCount}][correct]"
                                                                                                                                                                                                                                                       value="${i}"
                                                                                                                                                                                                                                                       id="question-${questionCount}-option-${i}"
                                                                                                                                                                                                                                                       required>
                                                                                                                                                                                                                                                <label class="form-check-label " for="question-${questionCount}-option-${i}">
                                                                                                                                                                                                                                                    Mark as correct
                                                                                                                                                                                                                                                </label>
                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                    `).join('')}
                                                                                                                                                                                                                                </div>

                                                                                                                                                                                                                                <small class="text-muted">
                                                                                                                                                                                                                                    Please mark <strong>only one</strong> correct option. The selected one will be used to grade this question.
                                                                                                                                                                                                                                </small>
                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                            `;

                wrapper.insertAdjacentHTML('beforeend', questionHTML);
                questionCount++;
            }
            function removeQuestion(el) {
                if (confirm('Are you sure you want to remove this question?')) {
                    const questionBlock = el.closest('.border.rounded.p-3.mb-4');
                    const questionIdInput = questionBlock.querySelector('input[name$="[id]"]');

                    if (questionIdInput) {
                        const deletedInput = document.getElementById('deleted-questions');
                        const existing = deletedInput.value ? deletedInput.value.split(',') : [];
                        existing.push(questionIdInput.value);
                        deletedInput.value = existing.join(',');
                    }

                    questionBlock.remove();
                }
            }

        </script>
    @endpush