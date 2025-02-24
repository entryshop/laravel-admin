<input class="filepond filepond-input-multiple"
       id="{{$_this->id()}}"
       data-allow-reorder="true" data-max-file-size="3MB" data-max-files="3"
       type="file"
       name="{{$_this->name()}}"
       placeholder="{{$_this->placeholder()}}"
       value="{{old($_this->name(), $_this->value())}}">

@push('scripts')
    <link rel="stylesheet" href="/vendor/admin/libs/filepond/filepond.min.css" type="text/css" />
    <link rel="stylesheet" href="/vendor/admin/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css">
    <script src="/vendor/admin/libs/filepond/filepond.min.js"></script>
    <script src="/vendor/admin/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js"></script>
    <script src="/vendor/admin/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js"></script>
    <script src="/vendor/admin/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js"></script>
    <script src="/vendor/admin/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js"></script>
    <script nonce="{{admin()->csp()}}">
        FilePond.registerPlugin(FilePondPluginFileEncode, FilePondPluginFileValidateSize, FilePondPluginImageExifOrientation, FilePondPluginImagePreview);
        let inputMultipleElements = document.querySelectorAll("input.filepond-input-multiple");
        if (inputMultipleElements) {
            Array.from(inputMultipleElements).forEach(function (e) {
                FilePond.create(e)
            })
        }
    </script>
@endpush
