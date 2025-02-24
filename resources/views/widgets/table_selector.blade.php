<div id="table_selector_{{$_this->id()}}"
     data-element="{{request('element')}}"
     data-nonce="{{request('_nonce')}}">
    @include('admin::grid', ['_this' => $_this])
</div>
<div class="mt-2">
    <button data-target="#users" class="btn-confirm-select btn btn-primary">@lang('admin::base.confirm')</button>
</div>

@push('scripts')
    <script nonce="{{admin()->csp()}}">
        $('.btn-confirm-select').on('click', function () {
            $($(this).data('target')).val(123);
        });
    </script>
@endpush
