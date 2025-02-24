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
                let data = new FormData(this);
                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: data,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        admin().response(data);
                    },
                    error: function (data) {
                        if (submit_btn) {
                            submit_btn.prop('disabled', false);
                        }
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
