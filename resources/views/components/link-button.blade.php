@props(['fullWidth' => false, 'href', 'primary' => false])

<div class="d-{{ $fullWidth ? 'grid' : 'inline-block' }}">
    <a {{ $attributes->class(['btn', 'btn-primary' => $primary, 'btn-secondary' => ! $primary])->merge(['href' => $href]) }}>{{ $slot }}</a>
</div>
