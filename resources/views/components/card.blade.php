<div {{ $attributes->class(['card']) }}>
    @isset($header)
        <header class="card-header">
            {{ $header }}
        </header>
    @endisset
    @isset($body)
        <div class="card-body">
            {{ $body }}
        </div>
    @endisset
    @isset($footer)
        <footer class="card-footer">
            {{ $footer }}
        </footer>
    @endisset
</div>
