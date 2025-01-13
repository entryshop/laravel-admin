<ul class="navbar-nav" id="navbar-nav">
    @foreach($menus??[] as $menu)
        {!! render($menu) !!}
    @endforeach
</ul>
