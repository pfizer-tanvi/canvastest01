@props(['active' => false, 'disabled' => false, 'href'])

<li>
    <a {{ $attributes->class(['active' => $active, 'disabled' => $disabled, 'dropdown-item'])->merge(['aria-disabled' => $disabled ? 'true' : false, 'href' => $href, 'tabindex' => $disabled ? '-1' : false]) }}>{{ $slot }}</a>
</li>
