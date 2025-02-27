<x-admin::input
    id="{{$_this->id()}}"
    :name="$_this->name()"
    :type="$_this->nativeType()"
    :readonly="$_this->get('readonly', false)"
    :value="old($_this->name(), $_this->value())"
    :placeholder="$_this->placeholder()"
/>
