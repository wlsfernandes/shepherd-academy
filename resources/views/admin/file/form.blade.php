@extends('admin.layouts.master')

@section('title', 'Add Task to ' . $task->title)

@section('content')
    <x-back-button route="course.index" />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <x-alert />

                <div class="card-body">

                    @if (!empty($file?->url))

                        <div class="mb-4">
                            <h5 class="mb-2">Uploaded File</h5>

                            <a href="{{ route('file.displayFile', $file->id) }}" target="_blank"
                                class="btn btn-outline-primary">
                                <i class="fas fa-file-alt me-1"></i>
                                View File
                            </a>
                        </div>
                    @endif
                    <!-- first create a PreSigned Javascript to Amazon S3 URL to upload diret to amazon After this the JScript its going to call Laravel Controller -->
                    <form id="upload-form" action="{{ route('files.store', $task->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" id="upload_folder" value="{{ $folder  }}">
                        <input type="hidden" name="task_id" value="{{ $task->id }}">
                        <input type="hidden" name="filename">
                        <input type="hidden" name="type">
                        <input type="hidden" name="key">

                        <x-mb3div label="File Name" name="title" :value="old('title', $file->title ?? '')"
                            :required="true" />

                        <div class="mb-3">
                            <label for="upload_file" class="form-label">Select File</label>
                            <input type="file" id="upload_file" class="form-control" required>
                        </div>

                        <button type="button" onclick="uploadToS3()" class="btn btn-primary">
                            Upload File
                        </button>
                        <progress id="uploadProgress" value="0" max="100"
                            style="margin-top:50px;width: 100%;height: 20px;display: none;appearance: none;-webkit-appearance: none;background-color: #f1f1f1;border-radius: 10px;overflow: hidden;color: #5b73e8;"></progress>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        async function uploadToS3() {
            const folder = document.getElementById('upload_folder').value;
            const file = document.getElementById('upload_file').files[0];
            const progressBar = document.getElementById('uploadProgress');

            if (!file) {
                alert('Please select a file.');
                return;
            }

            const contentType = file.type || 'application/octet-stream';

            // 1️⃣ Request presigned URL
            const res = await fetch('/s3-presigned-url', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    filename: file.name,
                    type: contentType,
                    folder: folder
                })
            });

            const { upload_url, key, public_url } = await res.json();

            // 2️⃣ Upload directly to S3
            progressBar.style.display = 'block';
            progressBar.value = 0;

            const xhr = new XMLHttpRequest();
            xhr.open('PUT', upload_url, true);

            // ✅ MUST MATCH WHAT WAS SIGNED
            xhr.setRequestHeader('Content-Type', contentType);

            xhr.upload.addEventListener('progress', function (e) {
                if (e.lengthComputable) {
                    progressBar.value = (e.loaded / e.total) * 100;
                }
            });

            xhr.onload = function () {
                if (xhr.status === 200 || xhr.status === 204) {

                    document.querySelector('input[name="filename"]').value = file.name;
                    document.querySelector('input[name="type"]').value = contentType;
                    document.querySelector('input[name="key"]').value = key;

                    document.querySelector('button[onclick="uploadToS3()"]').disabled = true;
                    document.getElementById('upload-form').submit();

                    console.log('Public URL:', public_url);
                    alert('Upload successful! 🎉');

                } else {
                    console.error(xhr.responseText);
                    alert('Upload failed');
                }
            };

            xhr.onerror = function () {
                alert('An error occurred during upload.');
            };

            xhr.send(file);
        }
    </script>



@endsection