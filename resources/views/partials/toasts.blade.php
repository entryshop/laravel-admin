<script nonce="{{admin()->csp()}}">
    @if(session()->has('__toast'))
    admin().toast(@json(session('__toast')));
    @endif
</script>
