<div class="input-group" id="{{$_this->id()}}">
    <select name="{{$_this->name()}}" class="form-select" disabled></select>
    <span role="button" class="btn-select btn btn-primary"><i class="ri-table-line"></i></span>
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
        .choices {
            margin-bottom: 0;
        }
    </style>
    <script nonce="{{admin()->csp()}}">
        function SelectTable(id) {
            let choice = new Choices("#" + id + ' select');

            $('#' + id + ' .btn-select').on('click', function () {
                $('.select-table-dialog[data-table=' + id + ']').modal('show');
                asyncLoad(
                    {
                        element: $('.select-table-dialog[data-table=' + id + ']').data('from'),
                        nonce: "{{admin()->csp()}}",
                    },
                    '.select-table-dialog[data-table=' + id + '] .modal-body'
                )
            });

            $('.select-table-dialog[data-table=' + id + '] button.btn-confirm').on('click', function () {
                let selected = [];
                $('.select-table-dialog[data-table=' + id + '] .modal-body .check:checked').each(function (index, item) {
                    selected.push({
                        id: $(item).data('id'),
                        label: $(item).data('label')
                    })
                });
                console.log(selected);
            });
        }

        function asyncLoad(params, container) {
            admin().asyncRender(
                "{{route(config('admin.as').'api.render.element')}}",
                params,
                function (data) {
                    $(container).html(data);
                    $(container + ' a').on("click", function (e) {
                        e.preventDefault();
                        let _params = admin().params(this.href);
                        _params.element = params.element;
                        _params._nonce = "{{admin()->csp()}}";
                        asyncLoad(_params, container);
                    });
                    $(container + " form").on("submit", function (e) {
                        e.preventDefault();
                        const formData = new FormData(this);
                        const _params = {};
                        formData.forEach((value, key) => {
                            _params[key] = value;
                        });
                        _params.element = params.element;
                        _params._nonce = "{{admin()->csp()}}";
                        asyncLoad(_params, container);
                        return false;
                    });
                }
            );
        }
    </script>
@endpushonce

@push('scripts')
    <script nonce="{{admin()->csp()}}">
        $(function () {
            SelectTable('{{$_this->id()}}');
        });
    </script>
@endpush
