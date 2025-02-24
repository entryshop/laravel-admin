<a role="button" href="{{$_this->sortUrl($name)}}">
    {!! $label !!}
    @if(request('sort_by') == $name)
        @if(request('sort_type') == 'desc')
            <i class="ri-sort-desc"></i>
        @endif
        @if(request('sort_type') == 'asc')
            <i class="ri-sort-asc"></i>
        @endif
    @else
        <i class="opacity-25 ri-arrow-up-down-fill"></i>
    @endif
</a>
