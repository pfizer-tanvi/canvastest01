@props(['id' => null, 'name'])

<div class="form-check">
    <input {{ $attributes->class(['form-check-input', 'is-invalid' => $errors->has($name)])->merge(['id' => $id ?? $name, 'name' => $name, 'type' => 'checkbox']) }}>
    <label class="form-check-label" for="{{ $id ?? $name }}">{{ $slot }}</label>
    <x-input-errors :for="$name" />
</div>
