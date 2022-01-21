@props(['last' => false])

<div {{ $attributes->class(['mb-3' => ! $last]) }}>
    {{ $slot }}
</div>
