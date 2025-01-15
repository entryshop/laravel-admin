@php
    $href = interpolate($_this->get('href'), array_merge($_this->get('context',[]), $_this->variables()));
    $action = interpolate($_this->get('action'), array_merge($_this->get('context',[]), $_this->variables()));
    $dom = $_this->get('dom', 'a');
@endphp

<a @if($href)
       target="{{$_this->get('target')}}" href="{{$href}}"
   @endif
   {!! $_this->attributes !!}
   @if($action)
       data-action="{{$action}}" data-method="{{$_this->get('method')}}"
   data-confirm="{{$_this->get('confirm')}}"
        @endif
>
    @if($_this->icon())
        <i class="{{$_this->icon()}}"></i>
    @endif
    {!! $_this->label() !!}
</a>
