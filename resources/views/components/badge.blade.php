@props([
    'type' => 'primary',
    'rounded' => false,
    'outline' => false,
    'label' => false,
])
@php
    $__class = ' badge ';

    if ($outline) {
        $__class .= ' border border-'. $type. ' text-' . $type;
    } else {
        $__class .= ' bg-'.$type;
    }

    if ($label) {
        $__class .= ' badge-label ';
    } else {

        if($rounded) {
            $__class .= ' rounded-pill ';
        }
    }
@endphp
<span {{$attributes->merge(['class' => $__class])}}>
    @if($label)
        <i class="mdi mdi-circle-medium"></i>
    @endif
    {{$slot}}
</span>
