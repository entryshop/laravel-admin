@php
    $href = interpolate($_this->get('href'), array_merge($_this->get('context',[]), $_this->variables()));
    $action = interpolate($_this->get('action'), array_merge($_this->get('context',[]), $_this->variables()));
    $dom = $_this->get('dom', 'a');
@endphp

<a role="button"
   id="{{$_this->id()}}"
   {!! $_this->attributes !!}

   @if($href)
       target="{{$_this->get('target')}}" href="{{$href}}"
   @endif

   @if($action)
       data-action="{{$action}}"
   data-method="{{$_this->get('method')}}"
   data-confirm="{{$_this->get('confirm')}}"
   @endif

   @if($_this->get('dialog'))
       data-bs-toggle="modal" data-bs-target="#{{$_this->id()}}-modal"
    @endif

>
    @if($_this->icon())
        <i class="{{$_this->icon()}}"></i>
    @endif
    {!! $_this->label() !!}
</a>

@if($_this->get('dialog'))
    <div id="{{$_this->id()}}-modal"
         class="modal fade"
         tabindex="-1"
         aria-hidden="true">
        <div class="modal-dialog modal-{{$_this->get('dialog')['size'] ??''}}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="myModalLabel">{!! $_this->get('dialog')['title'] ?? $_this->label() !!}</h5>
                    <span class="ms-1 btn-refresh d-none" type="button" aria-label="Refresh"><i
                            class="ri-refresh-line"></i></span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
    @pushonce('scripts')
        <script nonce="{{admin()->csp()}}">
            function getRenderContent(params, id) {
                $.ajax({
                    url: "{{route(config('admin.as').'api.render.element')}}",
                    type: 'get',
                    data: params,
                    success: function (response) {
                        $('#' + id + '-modal .modal-body').html(response);
                        $("#" + id + "-modal a").on("click", function (e) {
                            e.preventDefault();
                            let _params = admin().params(this.href);
                            _params.element = params.element;
                            _params._nonce = "{{admin()->csp()}}";
                            getRenderContent(_params, id);
                        });

                        $("#" + id + "-modal form").on("submit", function (e) {
                            e.preventDefault();
                            const formData = new FormData(this);
                            const _params = {};
                            // 转换 FormData 为普通对象
                            formData.forEach((value, key) => {
                                _params[key] = value;
                            });
                            _params.element = params.element;
                            _params._nonce = "{{admin()->csp()}}";
                            getRenderContent(_params, id);
                            return false;
                        });
                    }
                });
            }
        </script>
    @endpushonce
    @push('scripts')
        <script nonce="{{admin()->csp()}}">
            let content_loaded_{{$_this->id()}} = false;
            let dialog_element_{{$_this->id()}} = `{{urlencode($_this->get('dialog')['element'])}}`;

            $('#{{$_this->id()}}').on('click', function () {
                if (!content_loaded_{{$_this->id()}}) {
                    getRenderContent({
                        element: dialog_element_{{$_this->id()}},
                        _nonce: "{{admin()->csp()}}"
                    }, "{{$_this->id()}}");
                    content_loaded_{{$_this->id()}} = true;
                }
                $('#{{$_this->id()}}-modal').modal('show');
            });
        </script>
    @endpush
@endif
