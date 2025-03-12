<div class="card" id="{{$_this->id()}}">
    <div class="card-header">
        <span class="card-title">
            @if(data_get($_this->model(), 'id'))
                @lang("admin::base.edit")
            @else
                @lang("admin::base.create")
            @endif
        </span>

        @if($actions = $_this->actions())
            <div class="float-end">
                {!! render($actions, ['model'=> $_this->model()]) !!}
            </div>
        @endif

    </div>
    <div class="card-body">
        {!! render($_this->form) !!}
    </div>
</div>
