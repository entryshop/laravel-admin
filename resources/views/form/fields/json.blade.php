<div id="{{$_this->id()}}">
</div>
<input type="hidden" name="{{$_this->name()}}" value="{{to_string($_this->value())}}">
@push('scripts')
    <script nonce="{{admin()->csp()}}">
        // create the editor
        const container = document.getElementById("{{$_this->id()}}")
        const options = {
            mode: 'tree',
            onChangeJSON: function (json) {
                document.querySelector('input[name="{{$_this->name()}}"]').value = JSON.stringify(json)
            }
        }
        const editor = new JSONEditor(container, options)

        // set json
        const initialJson = @json(old($_this->name(), $_this->value()))

        editor.set(initialJson)

        // get json
        const updatedJson = editor.get()
    </script>
@endpush
