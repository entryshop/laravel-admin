<x-admin::input
    id="{{$_this->id()}}"
    name="{{$_this->name()}}"
    type="file"
    :readonly="$_this->get('readonly', false)"
    :value="old($_this->name(), $_this->value())"
    :placeholder="$_this->placeholder()"
/>

@if($image  = $_this->value())
    <div class="simplebar-content-wrapper mt-2" tabindex="0" role="region" aria-label="scrollable content">
        <div class="simplebar-content">
            <ul class="list-group mb-1">
                <li class="list-group-item">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <img src="{{$image}}" alt="" class="avatar-xs rounded">
                                </div>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <span class="text-danger">
                                <a class="text-danger remove-image" role="button">
                                    <i class="ri-delete-bin-2-line"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
@endif

@pushonce('scripts')
    <script nonce="{{admin()->csp()}}">
        $('.remove-image').on('click', function () {
            let $this = $(this);
            $this.closest('form').find('input[name="{{$_this->name()}}_remove"]').val('1');
            // hide image
            $this.closest('.list-group-item').hide();
        })
    </script>
@endpushonce
