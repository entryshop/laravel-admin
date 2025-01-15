<div class="card">
    <div class="card-header">
        <h6 class="card-title mb-0">
            @lang('admin::base.detail')
        </h6>
    </div>
    <div class="card-body">
        <div class="d-flex gap-3 flex-wrap">
            @foreach($_this->details()??[] as $detail)
                <div @if($detail->full()) class="w-full col-12" @endif>
                    <label class="text-muted" for="{{$detail->id()}}">
                        <small>{{$detail->label()}}</small>
                    </label>
                    <div>
                        {!! render($detail, ['model' => $_this->model()]) !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
