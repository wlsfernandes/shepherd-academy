@extends('admin.layouts.master')

@section('title', 'Upload Image')

@section('content')
    <div class="card border border-primary">
        <div class="card-header">
            <h5>
                <i class="uil-image-upload"></i>
                Upload Image
            </h5>
        </div>

        <div class="card-body">
            <x-alert />

            <div class="bg-info bg-opacity-10 text-info small p-3 rounded mb-4">
                Upload an image. It will be automatically converted to
                <strong>WebP</strong> and optimized.
            </div>

            @if($image)
                <div class="mb-3">
                    <img src="{{ route('admin.images.preview', ['model' => $modelKey, 'id' => $model->id]) }}"
                        class="img-thumbnail" style="max-height: 200px;" alt="Current image">
                </div>
            @endif

            <form method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <input type="file" name="image" class="form-control" accept="image/*" required>
                    <small class="text-muted">
                        JPG, PNG, or WebP. Max 5MB.
                    </small>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">
                        Back
                    </a>

                    <button class="btn btn-primary">
                        Upload Image
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection