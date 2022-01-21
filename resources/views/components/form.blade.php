@props(['action', 'files' => false, 'method' => 'POST'])

@php
    $method = strtoupper($method);
    $spoofMethod = null;

    if (! in_array($method, ['GET', 'POST'])) {
        $spoofMethod = $method;
        $method = 'POST';
    }
@endphp

<form {{ $attributes->merge(['action' => $action, 'enctype' => $files ? 'multipart/form-data' : false, 'method' => $method]) }}>
    @if($spoofMethod)
        <input type="hidden" name="_method" value="{{ $spoofMethod }}">
    @endif
    @unless($method === 'GET')
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @endunless
    {{ $slot }}
</form>
