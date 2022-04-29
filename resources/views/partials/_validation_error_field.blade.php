@if ($errors->has($field))
    <span class="text-sm text-red-700"><i class="fas fa-times-circle"></i> {{ $errors->first($field) }}</span>
@endif
