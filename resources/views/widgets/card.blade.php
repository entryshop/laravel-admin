<div {!!$_this->getAttributes()->merge(['class' =>'card'])  !!}>
    @if(($header = $_this->header()) || ($title = $_this->title()))
        <div class="card-header">
            @if(!empty($title))
                <h6 class="card-title mb-0">{{$title}}</h6>
            @endif
            @if(!empty($header))
                {{render($header)}}
            @endif
        </div>
    @endif
    @if($body = $_this->body())
        <div class="card-body">
            {!! render($body) !!}
        </div>
    @endif
    @if($footer = $_this->footer())
        <div class="card-footer">
            {{render($footer)}}
        </div>
    @endif
</div>
