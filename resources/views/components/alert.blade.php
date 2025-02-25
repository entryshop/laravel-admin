@props([
    'type' => 'primary',
    'closeable' => true,
    'icon' => null,
])
<div {{ $attributes->merge(['class' => 'material-shadow alert alert-'.$type.($closeable?' alert-dismissible fade show':'').($icon?' alert-label-icon':'')])}}>
    @if($icon)
        <i class="label-icon {{$icon}}"></i>
    @endif
    {{$slot}}
    @if($closeable)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>
