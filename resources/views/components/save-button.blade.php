<div class="d-flex justify-content-between">
    <a href="javascript:history.back()" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Go Back
    </a>

    @if (!$isViewing)
        <button type="submit" class="btn btn-primary">
            {{ $isEditing ? 'Update' : 'Create' }}
        </button>
    @endif
</div>