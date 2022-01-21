@props(['id' => null, 'label', 'name', 'placeholder' => null, 'type' => 'text'])

<div class="form-floating">
    <input {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)])->merge(['id' => $id ?? $name, 'name' => $name, 'placeholder' => $placeholder ?? $label, 'type' => $type]) }}>
    <label for="{{ $id ?? $name }}">{{ $label }}</label>
    <x-input-errors :for="$name" />
</div>
