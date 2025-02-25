@props([
    'type' => 'primary',
    'size' => '',
])
<button {{ $attributes->merge(['class' => 'btn btn-'.$type. ' btn-'.$size]) }}>
    {{$slot}}
</button>
