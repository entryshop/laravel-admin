<select
    class="form-select" name="{{$_this->name()}}" id="{{$_this->id()}}">
    @foreach($_this->options()??[] as $key => $value)
        <option value="{{$key}}" @if($_this->value() == $key) selected @endif>{{$value}}</option>
    @endforeach
</select>

@pushonce('styles')
    <style nonce="{{admin()->csp()}}">
        .choices {
            min-width: 100px;
        }
    </style>
@endpushonce

@push('scripts')
    <script nonce="{{admin()->csp()}}">
        $(function () {
            new Choices('#{{$_this->id()}}', {
                removeItems: true,
                removeItemButton: true,
            });
        });
    </script>
@endpush
