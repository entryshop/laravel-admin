<div class="card" id="{{$_this->id()}}">
    <div class="card-header">
        <span class="card-title">
            @if(data_get($_this->model(), 'id'))
                @lang("admin::base.edit")
            @else
                @lang("admin::base.create")
            @endif
        </span>
    </div>
    <div class="card-body">
        {!! render($_this->form) !!}
    </div>
</div>
