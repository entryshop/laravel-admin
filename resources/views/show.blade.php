<div class="card" id="{{$_this->id()}}">
    <div class="card-header">
        <span class="card-title">
            @lang('admin::base.detail')
        </span>
    </div>
    <div class="card-body">
        <div class="d-flex gap-3 flex-wrap">
            @foreach($_this->details()??[] as $detail)
                <div @if($detail->full()) class="w-full col-12" @endif>
                    <label class="text-muted" for="{{$detail->id()}}">
                        <small>{{$detail->label()}}</small>
                    </label>
                    <div>
                        {!! $detail->model($_this->model())->render() !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
