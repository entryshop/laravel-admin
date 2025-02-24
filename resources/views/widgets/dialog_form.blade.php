<div>
    <div id="errors_{{$_this->id()}}" class="alert alert-danger">
        <div class="d-flex flex-column errors">
        </div>
    </div>
    @include('admin::form.form', ['_this' => $_this])
</div>

@push('scripts')
    <script nonce="{{admin()->csp()}}">
        ajaxForm("{{$_this->id()}}");

        function ajaxForm(id) {
            let form = $("form#" + id);
            let errors_container = $("#errors_" + id);
            errors_container.hide();
            form.on('submit', function (e) {
                e.stopPropagation();
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
                            errors_container.find('.errors').html('');
                            errors_container.show();
                            form.find("[name]").removeClass('is-invalid');
                            let errors = data.responseJSON.errors;
                            for (let key in errors) {
                                if (errors.hasOwnProperty(key)) {
                                    let error = errors[key][0];
                                    let field = form.find("[name=" + key + "]");
                                    field.addClass('is-invalid');
                                    $("#errors_" + id + ' .errors').append("<span>" + error + "</span>");
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
