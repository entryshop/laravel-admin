<div class="card">
    <div class="card-header">
        <h6 class="card-title mb-0">
            @if(data_get($_this->model(), 'id'))
                @lang("admin::base.edit")
            @else
                @lang("admin::base.create")
            @endif
        </h6>
    </div>
    <div class="card-body">
        {!! render($_this->form) !!}
    </div>
</div>
