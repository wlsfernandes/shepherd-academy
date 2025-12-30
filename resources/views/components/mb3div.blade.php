<div class="mb-3 row">
    <label for="{{ $name }}" class="col-md-2 col-form-label">{{ $label }}:</label>
    <div class="col-md-10">
        <input class="form-control" id="{{ $name }}" name="{{ $name }}" type="text"
            value="{{ old($name, $value ?? '') }}" @if(!empty($required)) required @endif @if(!empty($disabled))
            disabled @endif>
    </div>
</div>