<div {!!$_this->getAttributes()->merge(['class' =>'card'])  !!}>
    @if($header = $_this->header())
        <div class="card-header">
            {{render($header)}}
        </div>
    @endif
    @if($body = $_this->body())
        <div class="card-body">
            {{render($body)}}
        </div>
    @endif
    @if($footer = $_this->footer())
        <div class="card-footer">
            {{render($footer)}}
        </div>
    @endif
</div>
