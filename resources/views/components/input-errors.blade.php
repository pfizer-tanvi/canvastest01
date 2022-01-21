@props(['for'])

@foreach($errors->get($for) as $error)
    <div class="invalid-feedback" role="alert">{{ $error }}</div>
@endforeach
