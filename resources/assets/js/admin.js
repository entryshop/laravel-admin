class Admin {

    init() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        this.initActionButton();
    }

    initActionButton() {
        $('[data-action]').on('click', function (event) {
            let confirm_message = $(this).data('confirm');
            if (confirm_message) {
                if (!confirm(confirm_message)) {
                    event.preventDefault();
                    event.stopPropagation();
                    return false;
                }
            }
            let action = $(this).data('action');
            let method = $(this).data('method');
            let payload = $(this).data('payload') || {};

            if ($(this).data('table')) {
                payload.ids = $('#' + $(this).data('table') + ' .check:checked').map(function () {
                    return $(this).data('id');
                }).get();
            }

            $.ajax(action, {
                method: method, data: payload, success: function (response) {
                    admin().response(response);
                }, error: function (error) {
                    console.log(error);
                }
            });
        });
    }

    response(response) {
        // check if response is json

        if (typeof response === 'string') {
            response = JSON.parse(response);
        }

        switch (response.action) {
            case 'redirect':
                window.location.href = response.url;
                break;
            case 'reload':
                window.location.reload();
                break;
            case 'close':
                $(`.modal`).modal('hide');
                break;
        }
    }

    errors(detail, container) {
        for (let key in detail) {
            $(`input[name=${key}]`).addClass('is-invalid');
        }
    }
}

window.admin = function () {
    if (!window._admin) {
        window._admin = new Admin();
    }
    return window._admin;
}

window.admin().init();

