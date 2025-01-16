<script nonce="{{admin()->csp()}}">
    @if(session()->has('__toast'))
    @php
        $toast = session('__toast');
    @endphp
    var toastData = @json($toast);
    Toastify({
        newWindow: true,
        text: toastData.text,
        gravity: toastData.gravity,
        position: toastData.position,
        className: "bg-" + toastData.className,
        stopOnFocus: true,
        escapeMarkup: false,
        offset: {
            x: toastData.offset ? 50 : 0, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
            y: toastData.offset ? 10 : 0, // vertical axis - can be a number or a string indicating unity. eg: '2em'
        },
        duration: toastData.duration,
        close: toastData.close == "close" ? true : false,
        style: toastData.style == "style" ? {
            background: "linear-gradient(to right, var(--vz-success), var(--vz-primary))"
        } : "",
    }).showToast();
    @endif
</script>
