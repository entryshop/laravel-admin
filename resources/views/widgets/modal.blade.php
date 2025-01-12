@php
    use Entryshop\Admin\Components\Element;
    $lazy = false;
    $dialog = $_this->dialog();
    if($dialog instanceof Element) {
        $lazy = $dialog->get('lazy', $lazy);
    }
    $payload = interpolate_recursive($dialog->payload(), array_merge($_this->context()??[], $_this->variables()));
@endphp

    <!-- Button trigger modal -->
<button type="button" class="btn btn-primary"
        @if($lazy)
            data-lazy-load
        data-element="{{get_class($dialog)}}"
        data-payload='{{to_string($payload)}}'
        @else
            data-bs-target="#{{$_this->id()}}"
        data-bs-toggle="modal"
    @endif
>
    {{render($_this->button())}}
</button>

<!-- Modal -->
@if($lazy)
    <div class="modal fade" id="data_lazy_dialog" tabindex="-1" aria-labelledby="data_lazy_label"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="data_lazy_label">{{$_this->title()}}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <i class="fa fa-spin fa-spinner"></i>
                </div>
            </div>
        </div>
    </div>
@else
@endif

@if($lazy)
    @pushonce('scripts')
        <script nonce="{{admin()->csp()}}">
            $(`[data-lazy-load]`).on('click', function () {
                let payload = $(this).data('payload');
                let element = $(this).data('element');
                $(`#data_lazy_dialog`).modal('show');
                $.post("{{route('admin.api.render.element')}}", {
                    _nonce: "{{csp_nonce()}}",
                    element: element,
                    payload: payload
                }).then(function (response) {
                    $(`#data_lazy_dialog .modal-body`).html(response);
                    ajaxFormSubmit();
                });
            });

            function ajaxFormSubmit() {
                $(`#data_lazy_dialog form`).off('submit').on('submit', function (e) {
                    e.preventDefault();
                    let form = $(this);
                    let action = form.attr('action');
                    let errorContainer = $(`#data_lazy_dialog .errors`);
                    let data = new FormData(this);
                    $('.btn-loading').prop('disabled', true);
                    $(`#data_lazy_dialog form input`).removeClass('is-invalid');
                    $.post({
                        url: action,
                        type: 'POST',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: data,
                    }).then(function (response) {
                        window.admin().response(response);
                    }).catch(function (error) {
                        errorContainer.removeClass('d-none');
                        errorContainer.html(error.responseJSON.message);
                        window.admin().errors(error.responseJSON.errors || []);
                    }).always(function () {
                    });
                })
            }
        </script>
    @endpushonce
@endif
