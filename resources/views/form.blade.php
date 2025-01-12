<div class="card">
    <div class="card-header">
        @if(data_get($_this->model(), 'id'))
            @lang("admin::base.edit")
        @else
            @lang("admin::base.create")
        @endif
    </div>
    <div class="card-body">
        {!! render($_this->form()) !!}
    </div>
</div>
