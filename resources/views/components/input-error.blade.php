@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1 shadow-xl']) }}>
        @foreach ((array) $messages as $message)
            <li class="p-4 bg-red-600 text-white rounded">{{ $message }}</li>
        @endforeach
    </ul>
@endif
