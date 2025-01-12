@foreach($children as $child)
    {!! render($child) !!}

    @if($child instanceof \Entryshop\Admin\Components\Element)
        @if($styles = $child->get('styles'))
            @push('styles')
                <style nonce="{{admin()->csp()}}">
                    {!! $styles !!}
                </style>
            @endpush
        @endif

        @if($scripts = $child->get('scripts'))
            @push('scripts')
                <script nonce="{{admin()->csp()}}">
                    {!! $scripts !!}
                </script>
            @endpush
        @endif
    @endif
@endforeach
