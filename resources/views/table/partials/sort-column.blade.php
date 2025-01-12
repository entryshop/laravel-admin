<a class="ms-1" href="{{$_this->sortUrl($name)}}">
    @if(request('sort_by') == $name)
        @if(request('sort_type') == 'desc')
            <i class="bi bi-sort-down"></i>
        @endif
        @if(request('sort_type') == 'asc')
            <i class="bi bi-sort-up"></i>
        @endif
    @else
        <i class="bi bi-filter-left"></i>
    @endif
</a>
