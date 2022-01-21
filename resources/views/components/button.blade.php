@props(['fullWidth' => false, 'primary' => false, 'type' => 'button'])

<div class="d-{{ $fullWidth ? 'grid' : 'inline-block' }}">
    <button {{ $attributes->class(['btn', 'btn-primary' => $primary, 'btn-secondary' => ! $primary])->merge(['type' => $type]) }}>{{ $slot }}</button>
</div>
