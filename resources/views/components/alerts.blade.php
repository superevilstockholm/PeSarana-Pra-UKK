@props(['errors'])
{{-- ->with('success', '...') | ->with('error', '...') | ->('warning', '...') | ->('info', '...') --}}
@foreach (['success', 'error', 'warning', 'info'] as $msg)
    @if (session($msg))
        <div class="alert alert-{{ $msg === 'error' ? 'danger' : $msg }}" role="alert">
            {{ session($msg) }}
        </div>
    @endif
@endforeach
{{-- ->withErrors('...') | ->withErrors(['...', '...']) --}}
@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        {{ $errors->first() }}
    </div>
@endif
