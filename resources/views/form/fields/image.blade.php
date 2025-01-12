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
       placeholder="{{$_this->placeholder()}}"
       value="{{old($_this->name(), $_this->value())}}">
@if(isset($error_message))
    <div class="invalid-feedback">
        {{$error_message}}
    </div>
@endif

@if($image  = $_this->value())
    <div>
        <input type="hidden" name="{{$_this->name()}}_remove" value="0">
        <div>
            <img class="mt-1" src="{{$image}}" alt="" width="80">
        </div>
        <small><a class="text-danger remove-image" role="button">Remove</a></small>
    </div>
    @push('scripts')
        <script nonce="{{admin()->csp()}}">
            $('.remove-image').on('click', function () {
                let $this = $(this);
                $this.closest('form').find('input[name="{{$_this->name()}}_remove"]').val('1');
                // hide image
                $this.closest('div').hide();
            })
        </script>
    @endpush
@endif
