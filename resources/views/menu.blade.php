@php
    $nest = false;
    $sub_menus = $_this->children();
    if(!empty($sub_menus)) {
        $nest = true;
    }
@endphp

<li class="nav-item">
    <a
        @if($nest)
            href="#{{$_this->id()}}" data-bs-toggle="collapse" role="button" aria-expanded="false"
        @else
            href="{{$_this->link()}}"
        @endif
        class="nav-link menu-link">
        @if($icon = $_this->icon())
            <i class="{{$icon}}"></i>
        @endif
        <span>{{$_this->label()}}</span>
    </a>
    @if(!empty($sub_menus))
        <div class="collapse menu-dropdown" id="{{$_this->id()}}">
            <ul class="nav nav-sm flex-column">
                @foreach($sub_menus as $sub_menu)
                    {!! render($sub_menu) !!}
                @endforeach
            </ul>
        </div>
    @endif
</li>
