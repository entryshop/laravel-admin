<a class="ms-1" href="{{$_this->sortUrl($name)}}">
    @if(request('sort_by') == $name)
        @if(request('sort_type') == 'desc')
            <i class="ri-sort-desc"></i>
        @endif
        @if(request('sort_type') == 'asc')
            <i class="ri-sort-asc"></i>
        @endif
    @else
        <i class="text-muted ri-arrow-up-down-fill"></i>
    @endif
</a>
