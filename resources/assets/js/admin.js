/**
 * Entryshop laravel admin
 * Author: Alex
 */
class Admin {
    cspNonce;

    init() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var metaElement = document.querySelector('meta[name="csp-nonce"]');

        if (metaElement) {
            this.cspNonce = metaElement.getAttribute('content');
        } else {
            console.log('can not found csp nonce');
        }

        this.initActionButton();
    }

    initActionButton() {
        $('[data-action]').on('click', async function (event) {
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

    params(url) {
        let params = {};
        try {
            // 创建 URL 对象
            const urlObj = new URL(url);

            // 获取 URLSearchParams 对象
            const searchParams = urlObj.searchParams;

            // 遍历所有参数并添加到对象中
            for (const [key, value] of searchParams) {
                params[key] = value;
            }

            return params;
        } catch (error) {
            console.error('Invalid URL:', error);
            return {};
        }
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
            case 'refresh':
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

(function () {

    window.admin = function () {
        if (!window._admin) {
            window._admin = new Admin();
        }
        return window._admin;
    }

    window.admin().init();
})();


