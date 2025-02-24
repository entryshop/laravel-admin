@php
    $class = '';
    if(!empty($errors->get($_this->name()))) {
        $class = 'is-invalid';
        $error_message = $errors->get($_this->name())[0] ?? null;
    }
@endphp

<input {!! $_this->getAttributes()->merge(['class' => $class]) !!}
       id="{{$_this->id()}}"
       type="file"
       @if($_this->readonly()) readonly disabled @endif
       name="{{$_this->name()}}"
       value="{{old($_this->name(), $_this->value())}}">
@if(isset($error_message))
    <div class="invalid-feedback">
        {{$error_message}}
    </div>
@endif
