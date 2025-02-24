<div id="table_selector_{{$_this->id()}}"
     data-element="{{request('element')}}"
     data-nonce="{{request('_nonce')}}">
    @include('admin::grid', ['_this' => $_this])
</div>
<div class="mt-2">
    <button class="btn btn-primary">@lang('admin::base.confirm')</button>
</div>
