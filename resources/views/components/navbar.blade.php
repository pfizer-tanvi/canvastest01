@props(['bg' => 'light', 'brand' => null, 'brandUrl' => null, 'dark' => false, 'expand' => 'sm', 'id' => 'app-navbar-content', 'light' => true])

<nav {{ $attributes->class(['navbar', 'navbar-expand-'.$expand, 'navbar-dark' => $dark, 'navbar-light' => $light, 'bg-'.$bg]) }}>
    <x-container>
        @if($brandUrl)
            <a class="navbar-brand" href="{{ $brandUrl }}">{{ $brand ?? config('app.name') }}</a>
        @else
            <span class="navbar-brand">{{ $brand ?? config('app.name') }}</span>
        @endif
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $id }}" aria-controls="{{ $id }}" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="{{ $id }}">
            {{ $content }}
        </div>
    </x-container>
</nav>
