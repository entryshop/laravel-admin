<select
    class="form-select" name="{{$_this->name()}}" id="{{$_this->id()}}">
    @foreach($_this->options()??[] as $key => $value)
        <option value="{{$key}}" @if($_this->value() == $key) selected @endif>{{$value}}</option>
    @endforeach
</select>
