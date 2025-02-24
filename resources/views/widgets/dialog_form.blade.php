<div>
    <div id="errors_{{$_this->id()}}"></div>
    @include('admin::form.form', ['_this' => $_this])
</div>

@push('scripts')
    <script nonce="{{admin()->csp()}}">
        ajaxForm("{{$_this->id()}}");

        function ajaxForm(id) {
            let form = $("form#" + id);
            form.on('submit', function (e) {
                e.stopPropagation();
                $("#errors_" + id).html('');
                let submit_btn = $(this).find('.btn-submit');
                if (submit_btn) {
                    submit_btn.prop('disabled', true);
                }
                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(),
                    success: function (data) {
                        switch (data.action) {
                            case 'refresh':
                                window.location.reload();
                                break;
                            case 'redirect':
                                window.location.href = data.url;
                                break;
                            default:
                                break;
                        }
                    },
                    error: function (data) {
                        console.log(data);
                        if (data.status === 422) {
                            let errors = data.responseJSON.errors;
                            for (let key in errors) {
                                if (errors.hasOwnProperty(key)) {
                                    let error = errors[key][0];
                                    $("#errors_" + id).append("<div class='alert alert-danger'>" + error + "</div>");
                                }
                            }
                        }
                    },
                    finally: function () {
                        if (submit_btn) {
                            submit_btn.prop('disabled', false);
                        }
                    }
                });
                return false;
            })
        }
    </script>
@endpush
