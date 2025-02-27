/**
 * Entryshop admin
 * Author: Alex (alex@parse.cn)
 */
class Admin {
    cspNonce;

    init() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const metaElement = document.querySelector('meta[name="csp-nonce"]');

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

    asyncRender(url, params, done, error) {
        $.ajax({
            type: 'get', url: url, data: params,
        }).then(function (data) {
            done(data);
        }, function (a, b, c) {
            if (error) {
                if (error(a, b, c) === false) {
                    return false;
                }
            }
        })
    }

    selectTable(options) {
        return new SelectTable(options);
    }
}

class SelectTable {
    constructor(options) {
        this.id = options.id;
        this.url = options.url;
        this.nonce = options.nonce;
        this.selected = [];
        this.choices = new Choices("#" + this.id + ' .form-select', {
            removeItemButton: true,
        });

        let that = this;
        $('#' + this.id + ' .btn-select').on('click', function () {
            $('.select-table-dialog[data-table=' + that.id + ']').modal('show');
            that.asyncLoad({
                    element: $('.select-table-dialog[data-table=' + that.id + ']').data('from'),
                    nonce: that.nonce,
                },
                '.select-table-dialog[data-table=' + that.id + '] .modal-body');
        });

        $('.select-table-dialog[data-table=' + that.id + '] button.btn-confirm').on('click', function () {
            let remove_select = [];
            $('.select-table-dialog[data-table=' + that.id + '] .modal-body .check:checked:not(.selected)').each(function (index, item) {
                let v = $(item).data('id') + "";
                that.selected.push({
                    value: v,
                    label: $(item).data('label')
                })
            });

            $('.select-table-dialog[data-table=' + that.id + '] .modal-body .check:not(:checked).selected').each(function (index, item) {
                remove_select.push($(item).data('id') + "");
            });

            // remove remove_select values from selected
            that.selected = that.selected.filter(item => !remove_select.includes(item.value));

            that.choices.clearChoices();
            that.choices.clearStore();
            that.choices.setValue(that.selected);
            $('.select-table-dialog[data-table=' + that.id + ']').modal('hide');
        });
    }

    asyncLoad(params, container) {
        let that = this;
        admin().asyncRender(this.url, params, function (data) {
            $(container).html(data);

            that.selected = [];
            let _values = that.choices.getValue();

            for (let i in _values) {
                let _value = _values[i];
                that.selected.push({
                    value: _value.value, label: _value.label
                })
            }
            for (let i in that.selected) {
                let id = that.selected[i]['value'];
                $(container + ' .check[data-id=' + id + ']').prop('checked', true);
                $(container + ' .check[data-id=' + id + ']').addClass('selected');
            }

            $(container + ' a').on("click", function (e) {
                e.preventDefault();
                let _params = admin().params(this.href);
                _params.element = params.element;
                _params._nonce = "{{admin()->csp()}}";
                that.asyncLoad(_params, container);
            });

            $(container + ' .check').on("change", function () {
                console.log($(this).data('id') + ' : ' + $(this).prop('checked'));
            });

            $(container + " form").on("submit", function (e) {
                e.preventDefault();
                const formData = new FormData(this);
                const _params = {};
                formData.forEach((value, key) => {
                    _params[key] = value;
                });
                _params.element = params.element;
                _params._nonce = "{{admin()->csp()}}";
                that.asyncLoad(_params, container);
                return false;
            });
        });
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


