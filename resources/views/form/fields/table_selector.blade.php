<div class="input-group" id="{{$_this->id()}}">
    <select multiple name="{{$_this->name()}}[]" class="form-select"></select>
    <div class="input-group-append">
        <span role="button" class="btn-select btn btn-primary"><i class="ri-table-line"></i></span>
    </div>
</div>

@push('after_body')
    <div class="select-table-dialog modal fade" data-table="{{$_this->id()}}" data-from="{{$_this->from()}}"
         tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg modal-fullscreen-xl-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Select</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light"
                            data-bs-dismiss="modal">@lang('admin::base.cancel')</button>
                    <button type="button" class="btn-confirm btn btn-primary">@lang('admin::base.confirm')</button>
                </div>
            </div>
        </div>
    </div>
@endpush

@pushonce('scripts')
    <style nonce="{{admin()->csp()}}">
        .choices__inner {
            min-width: 120px;
            max-width: 400px;
        }

        .choices {
            margin-bottom: 0;
        }
    </style>
@endpushonce

@push('scripts')
    <script nonce="{{admin()->csp()}}">
        $(function () {
            admin().selectTable({
                url: "{{route(config('admin.as').'api.render.element')}}",
                nonce: "{{admin()->csp()}}",
                id: '{{$_this->id()}}'
            });
        });
    </script>
@endpush
