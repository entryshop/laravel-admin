@props([
    'type' => 'text',
    'readonly' => false,
    'placeholder' => '',
    'value' => '',
    'name' => '',
    'id' => '',
])

@php
    $error = $errors->get($name)[0] ?? null;
@endphp

<input {{$attributes->merge(['class' => 'form-control '. ($error ? 'is-invalid':'')])}}
       type="{{$type}}"
       value="{{$value}}"
       name="{{$name}}"
       id="{{$id}}"
       placeholder="{{$placeholder}}"
       @if($readonly) readonly @endif
>

@if($error)
    <div class="invalid-feedback">
        {{$error}}
    </div>
@endif
